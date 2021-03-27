<?php
declare(strict_types=1);

namespace DDDCodeTest\Backoffice\BudgetsLines\Domain;

use DDDCodeTest\Shared\Domain\ValueObject\FloatValueObject;
use InvalidArgumentException;

final class LineVatAmount extends FloatValueObject
{
    public function __construct(float $value, LineNetAmount $netAmount, LineVat $vat)
    {
        parent::__construct($value);
        $this->validateVatFormula($netAmount, $vat);
    }

    private function validateVatFormula(LineNetAmount $netAmount, LineVat $vat): void
    {
        if ($this->round($netAmount->value() * $vat->value() / 100) !== $this->value()) {
            throw new InvalidArgumentException(
                sprintf('Invalid vat amount with value <%s>', $this->value())
            );
        }
    }
}
