<?php
declare(strict_types=1);

namespace DDDCodeTest\Backoffice\Budgets\Infrastructure\Persistence;

use DDDCodeTest\Backoffice\Budgets\Domain\Budget;
use DDDCodeTest\Backoffice\Budgets\Domain\BudgetCreatedAt;
use DDDCodeTest\Backoffice\Budgets\Domain\BudgetId;
use DDDCodeTest\Backoffice\Budgets\Domain\BudgetRepository;
use DDDCodeTest\Backoffice\Budgets\Domain\BudgetTotalAmount;
use DDDCodeTest\Backoffice\Budgets\Infrastructure\Persistence\Eloquent\BudgetEloquentModel;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\Line;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\LineCreatedAt;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\LineId;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\LineNetAmount;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\LineRepository;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\Lines as BudgetLines;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\LineTotalAmount;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\LineVat;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\LineVatAmount;
use DDDCodeTest\Backoffice\BudgetsLines\Infrastructure\Persistence\Eloquent\BudgetLineEloquentModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EloquentBudgetRepository implements BudgetRepository
{
    private LineRepository $lineRepository;

    public function __construct(LineRepository $lineRepository)
    {
        $this->lineRepository = $lineRepository;
    }

    public function save(Budget $budget): void
    {
        $budgetModel = new BudgetEloquentModel;
        $budgetModel->setAttribute('total_amount', $budget->getTotalAmount()->value());

        DB::transaction(function () use ($budget, $budgetModel) {
            $budgetModel->save();
            $budget->setId(new BudgetId((int)$budgetModel->id));
            $budget->setCreatedAt(new BudgetCreatedAt((string)$budgetModel->created_at));

            $this->lineRepository->saveMany($budget);
        });
    }

    public function search(BudgetId $id): ?Budget
    {
        /**@var BudgetEloquentModel $budgetModel */
        $budgetModel = BudgetEloquentModel::query()->with('lines')->find($id->value());

        if (null === $budgetModel) {
            return null;
        }

        $lines = $this->makeLineCollection($budgetModel);

        return new Budget(
            new BudgetLines($lines),
            new BudgetTotalAmount((float)$budgetModel->total_amount),
            new BudgetId((int)$budgetModel->id),
            new BudgetCreatedAt((string)$budgetModel->created_at)
        );
    }

    private function makeLineCollection(BudgetEloquentModel $budgetModel): array
    {
        $lines = [];
        foreach ($budgetModel->getRelationValue('lines') as $lineModel) {
            $lines[] = new Line(
                $netAmount = new LineNetAmount($lineModel->net_amount),
                $vat = new LineVat($lineModel->vat),
                new LineVatAmount($lineModel->vat_amount, $netAmount, $vat),
                new LineTotalAmount($lineModel->net_amount, $lineModel->vat_amount),
                new LineId((int)$lineModel->id),
                new LineCreatedAt((string)$lineModel->created_at)
            );
        }
        return $lines;
    }
}
