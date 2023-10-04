<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'members');
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    public function inputs(): HasMany
    {
        return $this->hasMany(Input::class);
    }

    public function outputs(): HasMany
    {
        return $this->hasMany(Output::class);
    }
}
