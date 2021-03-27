<?php
declare(strict_types=1);

namespace DDDCodeTest\Backoffice\Budgets\Infrastructure\Persistence\Eloquent;

use DDDCodeTest\Backoffice\BudgetsLines\Infrastructure\Persistence\Eloquent\BudgetLineEloquentModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetEloquentModel extends Model
{
    protected $table = 'budgets';
    protected $casts = [
        'total_amount' => 'float',
    ];

    public function lines(): HasMany
    {
        return $this->hasMany(BudgetLineEloquentModel::class, 'budget_id');
    }
}
