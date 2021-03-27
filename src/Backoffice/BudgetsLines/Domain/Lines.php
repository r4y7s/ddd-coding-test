<?php
declare(strict_types=1);

namespace DDDCodeTest\Backoffice\BudgetsLines\Domain;

use DDDCodeTest\Shared\Domain\Collection;

final class Lines extends Collection
{
    protected function type(): string
    {
        return Line::class;
    }

    public function calculateTotalAmount(): float
    {
        $totalAmount = 0;
        foreach ($this->getIterator() as $item) {
            /**@var Line $item */
            $totalAmount += $item->getTotalAmount()->value();
        }

        return (float)$totalAmount;
    }
}
