<?php

namespace Tests\Unit\DDDCodeTest\Backoffice\BudgetsLines\Domain;

use DDDCodeTest\Backoffice\BudgetsLines\Domain\Line;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\Lines;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LinesTest extends TestCase
{
    /** @test */
    public function it_should_throw_an_exception_when_class_type_not_match()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The object <stdClass> is not an instance of <DDDCodeTest\Backoffice\BudgetsLines\Domain\Line>");

        new Lines([
            new \stdClass(),
            new \stdClass()
        ]);
    }

    /** @test */
    public function it_should_match_line_total_with_expected()
    {
        $lines = new Lines([
            Line::create(
                159.6,
                21,
                33.52
            ),
            Line::create(
                247.11,
                21,
                51.89
            )
        ]);

        $this->assertEquals(492.12, $lines->calculateTotalAmount());
    }
}
