<?php

namespace Tests\Unit\DDDCodeTest\Backoffice\BudgetsLines\Domain;

use DDDCodeTest\Backoffice\BudgetsLines\Domain\LineNetAmount;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\LineVat;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\LineVatAmount;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LineVatAmountTest extends TestCase
{
    /** @test */
    public function it_should_throw_an_exception_when_vat_formula_not_match()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid vat amount with value <0.05>');

        new LineVatAmount(
            0.05,
            new LineNetAmount(5.04),
            new LineVat(21)
        );
    }
}
