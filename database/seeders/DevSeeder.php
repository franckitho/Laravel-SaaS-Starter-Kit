<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Filament\UserFilament;
use Illuminate\Support\Facades\Hash;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserFilament::create([
            'name' => 'username',
            'email' => 'yourmail@domain.com',
            'password' => Hash::make('password'),
        ]);

        User::factory(80)->create();

    }
}
