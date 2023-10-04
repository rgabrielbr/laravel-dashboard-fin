<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Output extends Model
{
    use Concerns\BelongsToTeam,
        HasFactory;

    protected $casts = [
        'value' => MoneyCast::class,
        'paid' => 'boolean',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function scopePaidOut(Builder $builder)
    {
        return $builder->where('paid', true);
    }
}
