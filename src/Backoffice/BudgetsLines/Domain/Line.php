<?php
declare(strict_types=1);

namespace DDDCodeTest\Backoffice\BudgetsLines\Domain;

final class Line
{
    private ?LineId $id;
    private LineNetAmount $netAmount;
    private LineVat $vat;
    private LineVatAmount $vatAmount;
    private LineTotalAmount $totalAmount;
    private ?LineCreatedAt $createdAt;

    public function __construct(
        LineNetAmount $netAmount,
        LineVat $vat,
        LineVatAmount $vatAmount,
        LineTotalAmount $totalAmount,
        ?LineId $id = null,
        ?LineCreatedAt $createdAt = null
    ) {
        $this->id = $id;
        $this->netAmount = $netAmount;
        $this->vat = $vat;
        $this->vatAmount = $vatAmount;
        $this->totalAmount = $totalAmount;
        $this->createdAt = $createdAt;
    }

    public static function create(float $netAmount, float $vat, float $vatAmount): self
    {
        return new self(
            $lineNetAmount = new LineNetAmount($netAmount),
            $lineVat = new LineVat($vat),
            new LineVatAmount($vatAmount, $lineNetAmount, $lineVat),
            new LineTotalAmount($netAmount, $vatAmount)
        );
    }

    public function getNetAmount(): LineNetAmount
    {
        return $this->netAmount;
    }

    public function getVat(): LineVat
    {
        return $this->vat;
    }

    public function getVatAmount(): LineVatAmount
    {
        return $this->vatAmount;
    }

    public function getTotalAmount(): LineTotalAmount
    {
        return $this->totalAmount;
    }

    public function getId(): ?LineId
    {
        return $this->id;
    }

    public function getCreatedAt(): ?LineCreatedAt
    {
        return $this->createdAt;
    }
}
