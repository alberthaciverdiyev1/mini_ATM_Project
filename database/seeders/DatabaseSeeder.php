<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(RoleSeeder::class);

       $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' =>Hash::make('admin'),
        ]);
        $user = User::factory()->create([
            'name' => 'user',
            'email' => 'user@user.com',
            'password' =>Hash::make('user'),
        ]);

       $admin->assignRole('admin');
       $user->assignRole('user');

    }
}
