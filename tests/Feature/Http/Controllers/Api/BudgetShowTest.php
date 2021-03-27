<?php

namespace Tests\Feature\Http\Controllers\Api;

use DDDCodeTest\Backoffice\Budgets\Infrastructure\Persistence\Eloquent\BudgetEloquentModel;
use DDDCodeTest\Backoffice\BudgetsLines\Infrastructure\Persistence\Eloquent\BudgetLineEloquentModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BudgetShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_find_an_existing_budget(): void
    {
        $model = new BudgetEloquentModel;
        $model->forceFill(['total_amount' => 193.12, 'created_at' => '2021-03-06 12:00:00']);
        $model->save();
        $line = new BudgetLineEloquentModel;
        $line->forceFill([
            'total_amount' => 193.12,
            'net_amount' => 159.6,
            'vat_amount' => 33.52,
            'vat' => 21,
            'budget_id' => $model->id,
            'created_at' => '2021-03-06 12:00:00'
        ]);
        $line->save();

        $response = $this->getJson(route('budget.show', ['invoiceId' => 1]));
        $response->assertOk();
        $response->assertJson([
            'budgetId' => $model->id,
            'totalAmount' => 193.12,
            'createdAt' => '2021-03-06 12:00:00',
            'budgetLine' => [
                [
                    'budgetLineId' => $line->id,
                    'netAmount' => 159.6,
                    'vatAmount' => 33.52,
                    'totalAmount' => 193.12,
                    'createdAt' => '2021-03-06 12:00:00',
                ]
            ],
        ]);
    }

    /** @test */
    public function it_should_throw_an_exception_when_budget_does_not_exists(): void
    {
        $response = $this->getJson(route('budget.show', ['invoiceId' => 5]));
        $response->assertStatus(404);
        $response->assertJsonFragment(['message' => 'The budget <5> does not exist']);
    }
}
