<?php

namespace Tests\Unit\DDDCodeTest\Backoffice\BudgetsLines\Domain;

use DDDCodeTest\Backoffice\BudgetsLines\Domain\Line;
use PHPUnit\Framework\TestCase;

class LineTest extends TestCase
{
    /** @test */
    public function it_should_create_instance_with_valid_data()
    {
        $line = Line::create(
            5.04,
            21,
            1.06
        );

        $this->assertInstanceOf(Line::class, $line);
        $this->assertNull($line->getId());//TODO make UUID
        $this->assertEquals(5.04, $line->getNetAmount()->value());
        $this->assertEquals(21, $line->getVat()->value());
        $this->assertEquals(1.06, $line->getVatAmount()->value());
        $this->assertEquals(6.1, $line->getTotalAmount()->value());
        $this->assertNull($line->getCreatedAt());
    }
}
