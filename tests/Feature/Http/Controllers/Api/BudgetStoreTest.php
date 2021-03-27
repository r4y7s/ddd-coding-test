<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BudgetStoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_create_a_valid_budget()
    {
        $response = $this->postJson(route('budget.store'), [
            [
                'netAmount' => 159.6,
                'vat' => 21,
                'vatAmount' => 33.52
            ],
            [
                'netAmount' => 247.11,
                'vat' => 21,
                'vatAmount' => 51.89
            ],
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseCount('budgets', 1);
        $this->assertDatabaseCount('budget_lines', 2);
        $this->assertDatabaseHas('budgets', [
            'total_amount' => 492.12
        ]);

        $this->assertDatabaseHas('budget_lines', [
            'total_amount' => 193.12,
            'net_amount' => 159.6,
            'vat_amount' => 33.52,
            'vat' => 21,
        ]);
        $this->assertDatabaseHas('budget_lines', [
            'total_amount' => 299,
            'net_amount' => 247.11,
            'vat_amount' => 51.89,
            'vat' => 21,
        ]);
    }

    /** @test */
    public function it_should_throw_an_exception_when_invalid_request(): void
    {
        $response = $this->postJson(route('budget.store'), [[]]);

        $response->assertStatus(422);
        $response->assertJsonFragment(['message' => 'The given data was invalid.']);
    }

    /** @test */
    public function it_should_throw_an_exception_when_invalid_vat_amount(): void
    {
        $response = $this->postJson(route('budget.store'), [
            [
                'netAmount' => 159.6,
                'vat' => 21,
                'vatAmount' => 5
            ]
        ]);

        $response->assertStatus(400);
        $response->assertJsonFragment(['message' => 'Invalid vat amount with value <5>']);
    }
}
