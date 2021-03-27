<?php
declare(strict_types=1);

namespace DDDCodeTest\Backoffice\Budgets\Application\Create;

use DDDCodeTest\Backoffice\Budgets\Domain\Budget;
use DDDCodeTest\Backoffice\Budgets\Domain\BudgetRepository;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\Line;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\Lines;

final class BudgetCreator
{
    private BudgetRepository $repository;

    public function __construct(BudgetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(array $budgetLine)
    {
        $lines = [];
        foreach ($budgetLine as $item) {
            $lines[] = Line::create(
                (float)$item['netAmount'],
                (float)$item['vat'],
                (float)$item['vatAmount'],
            );
        }
        $budget = Budget::create(new Lines($lines));

        $this->repository->save($budget);
    }
}
