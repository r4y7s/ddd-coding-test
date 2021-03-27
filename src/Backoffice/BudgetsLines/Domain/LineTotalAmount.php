<?php
declare(strict_types=1);

namespace DDDCodeTest\Backoffice\BudgetsLines\Domain;

use DDDCodeTest\Shared\Domain\ValueObject\FloatValueObject;

final class LineTotalAmount extends FloatValueObject
{
    public function __construct(float $netAmount, float $vatAmount)
    {
        parent::__construct($netAmount + $vatAmount);
    }
}
