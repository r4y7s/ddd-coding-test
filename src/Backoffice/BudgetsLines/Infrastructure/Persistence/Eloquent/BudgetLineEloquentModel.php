<?php
declare(strict_types=1);

namespace DDDCodeTest\Backoffice\BudgetsLines\Infrastructure\Persistence\Eloquent;

use DDDCodeTest\Backoffice\Budgets\Infrastructure\Persistence\Eloquent\BudgetEloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class BudgetLineEloquentModel extends Model
{
    protected $table = 'budget_lines';
    protected $casts = [
        'total_amount' => 'float',
        'net_amount' => 'float',
        'vat_amount' => 'float',
        'vat' => 'float',
    ];

    public function budget(): BelongsTo
    {
        return $this->belongsTo(BudgetEloquentModel::class, 'budget_id');
    }
}
