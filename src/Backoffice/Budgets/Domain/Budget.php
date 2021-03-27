<?php
declare(strict_types=1);

namespace DDDCodeTest\Backoffice\Budgets\Domain;

use DDDCodeTest\Backoffice\BudgetsLines\Domain\Lines as BudgetLines;

final class Budget
{
    private ?BudgetId $id;
    private BudgetLines $budgetLines;
    private BudgetTotalAmount $totalAmount;
    private ?BudgetCreatedAt $createdAt;

    public function __construct(
        BudgetLines $budgetLines,
        BudgetTotalAmount $totalAmount,
        ?BudgetId $id = null,
        ?BudgetCreatedAt $createdAt = null
    ) {
        $this->id = $id;
        $this->budgetLines = $budgetLines;
        $this->totalAmount = $totalAmount;
        $this->createdAt = $createdAt;
    }

    public static function create(BudgetLines $budgetLines): self
    {
        return new self($budgetLines, new BudgetTotalAmount($budgetLines->calculateTotalAmount()));
    }

    public function getBudgetLines(): BudgetLines
    {
        return $this->budgetLines;
    }

    public function getTotalAmount(): BudgetTotalAmount
    {
        return $this->totalAmount;
    }

    public function getId(): ?BudgetId
    {
        return $this->id;
    }

    public function setId(BudgetId $id): void
    {
        $this->id = $id;
    }

    public function getCreatedAt(): ?BudgetCreatedAt
    {
        return $this->createdAt;
    }

    public function setCreatedAt(BudgetCreatedAt $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
