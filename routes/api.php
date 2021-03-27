<?php

use App\Http\Controllers\Api\{BudgetShow, BudgetStore};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('invoices/{invoiceId}', BudgetShow::class)->name('budget.show');
Route::post('invoices', BudgetStore::class)->name('budget.store');
