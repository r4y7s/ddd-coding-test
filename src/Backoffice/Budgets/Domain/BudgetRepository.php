<?php
declare(strict_types=1);

namespace DDDCodeTest\Backoffice\Budgets\Domain;

interface BudgetRepository
{
    public function save(Budget $budget): void;

    public function search(BudgetId $id): ?Budget;
}
