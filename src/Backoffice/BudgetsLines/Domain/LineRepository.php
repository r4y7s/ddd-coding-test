<?php
declare(strict_types=1);

namespace DDDCodeTest\Backoffice\BudgetsLines\Domain;

use DDDCodeTest\Backoffice\Budgets\Domain\Budget;

interface LineRepository
{
    public function saveMany(Budget $budget): void;
}
