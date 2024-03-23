<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserFilament;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserFilament::create([
            'name' => 'franck',
            'email' => 'contact@franckcolonna.fr',  
            'password' => '$2y$10$jCYK/qcjCBOw5WmX/u2T/ecWDZ.FHdAu2lw.IX.o3rj2rKzZPQYoW',
        ]);

        User::factory(80)->create();

    }
}
