<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin System',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas UPT',
            'username' => 'upt',
            'password' => Hash::make('upt123'),
            'role' => 'upt',
        ]);

        $this->call([
            MenuSeeder::class,
            SubmenuSeeder::class,
            SliderSeeder::class,
        ]);
    }
}
