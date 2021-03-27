<?php
declare(strict_types=1);

namespace DDDCodeTest\Backoffice\Budgets\Domain;

use DomainException;

final class BudgetNotExist extends DomainException
{
    public function __construct(BudgetId $id)
    {
        parent::__construct(sprintf('The budget <%s> does not exist', $id->value()));
    }
}
