<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use Concerns\BelongsToTeam,
        HasFactory;

    public function inputs(): HasMany
    {
        return $this->hasMany(Input::class);
    }

    public function outputs(): HasMany
    {
        return $this->hasMany(Output::class);
    }

    public function balance()
    {
        return $this->inputs()->sum('value') - $this->outputs()->paidOut()->sum('value');
    }
}
