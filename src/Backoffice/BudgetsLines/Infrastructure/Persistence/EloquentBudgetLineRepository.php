<?php
declare(strict_types=1);

namespace DDDCodeTest\Backoffice\BudgetsLines\Infrastructure\Persistence;

use DDDCodeTest\Backoffice\Budgets\Domain\Budget;
use DDDCodeTest\Backoffice\Budgets\Domain\BudgetNotExist;
use DDDCodeTest\Backoffice\Budgets\Infrastructure\Persistence\Eloquent\BudgetEloquentModel;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\Line;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\LineRepository;
use DDDCodeTest\Backoffice\BudgetsLines\Infrastructure\Persistence\Eloquent\BudgetLineEloquentModel;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class EloquentBudgetLineRepository implements LineRepository
{
    public function saveMany(Budget $budget): void
    {
        $budgetModel = $this->getEloquentBudgetModel($budget);
        $budgetModel->lines()->saveMany($this->makeBudgetLineCollection($budget));
    }

    private function getEloquentBudgetModel(Budget $budget): BudgetEloquentModel
    {
        $budgetId = $budget->getId();
        if (null === $budgetId) {
            throw new InvalidArgumentException(
                sprintf('The Budget not has BudgetId instance')
            );
        }

        /**@var BudgetEloquentModel $budgetModel */
        $budgetModel = BudgetEloquentModel::query()->find($budgetId->value());
        if (null === $budgetModel) {
            throw new BudgetNotExist($budgetId);
        }

        return $budgetModel;
    }

    private function makeBudgetLineCollection(Budget $budget): Collection
    {
        $lineModelCollection = new Collection;

        foreach ($budget->getBudgetLines()->getIterator() as $line) {
            /**@var Line $line */
            $lineModel = new BudgetLineEloquentModel;
            $lineModel->setAttribute('total_amount', $line->getTotalAmount());
            $lineModel->setAttribute('net_amount', $line->getNetAmount());
            $lineModel->setAttribute('vat_amount', $line->getVatAmount());
            $lineModel->setAttribute('vat', $line->getVat());
            $lineModelCollection->add($lineModel);
        }

        return $lineModelCollection;
    }


}
