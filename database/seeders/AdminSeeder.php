<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'user_role_id' => config('constant.ROLE_ID.SUPER_ADMIN_ROLE_ID'),
            'password' => Hash::make('admin@123'),
            'email_verified_at' => now(),
        ]);
    }
}
