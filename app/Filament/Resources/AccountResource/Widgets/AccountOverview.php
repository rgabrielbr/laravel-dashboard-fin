<?php

namespace App\Filament\Resources\AccountResource\Widgets;

use App\Models\Account;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AccountOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $accounts = Account::query()
            ->whereBelongsTo(Filament::getTenant())
            ->get();

        $stats = collect();
        foreach ($accounts as $account) {
            $stats->push(
                Stat::make($account->name, $account->balance())
            );
        }

        return $stats->toArray();
    }
}
