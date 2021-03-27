<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('budget_lines', function (Blueprint $table) {
            $table->id('id');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('net_amount', 10, 2);
            $table->decimal('vat_amount', 10, 2);
            $table->decimal('vat', 10, 2);

            $table->foreignId('budget_id')->constrained('budgets');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budget_lines');
        Schema::dropIfExists('budgets');
    }
}
