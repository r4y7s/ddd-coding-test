<?php
declare(strict_types=1);

namespace DDDCodeTest\Backoffice\Budgets\Application\Find;

use DDDCodeTest\Backoffice\Budgets\Domain\Budget;
use DDDCodeTest\Backoffice\Budgets\Domain\BudgetId;
use DDDCodeTest\Backoffice\Budgets\Domain\BudgetNotExist;
use DDDCodeTest\Backoffice\Budgets\Domain\BudgetRepository;

final class BudgetFinder
{
    private BudgetRepository $repository;

    public function __construct(BudgetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(BudgetId $id): Budget
    {
        $budget = $this->repository->search($id);

        if (null === $budget) {
            throw new BudgetNotExist($id);
        }

        return $budget;
    }
}
