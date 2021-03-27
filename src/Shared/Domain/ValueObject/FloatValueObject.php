<?php
declare(strict_types=1);

namespace DDDCodeTest\Shared\Domain\ValueObject;

abstract class FloatValueObject
{
    protected float $value;
    protected int $precision = 2;
    protected int $mode = PHP_ROUND_HALF_UP;

    public function __construct(float $value)
    {
        $this->value = $this->round($value);
    }

    public function value(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value();
    }

    public function round(float $value): float
    {
        return round($value, $this->precision, $this->mode);
    }
}
