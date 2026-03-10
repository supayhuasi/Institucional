<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => 'admin@institucional.local',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('admin1234'),
        ]);

        $this->call([
            SiteSetupSeeder::class,
        ]);
    }
}
