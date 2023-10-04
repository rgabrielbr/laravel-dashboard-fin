<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Account;
use App\Models\Input;
use App\Models\Output;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Gabriel',
            'email' => 'gabriel@email.com',
        ]);

        $team = Team::factory()->create();
        $team->members()->attach($user);

        $accounts = Account::factory(3)->for($team)->create();
        $accounts->each(function (Account $account) use ($team) {
            Input::factory(100)
                ->for($account)
                ->for($team)
                ->create();

            Output::factory(100)
                ->for($account)
                ->for($team)
                ->create();
        });
    }
}
