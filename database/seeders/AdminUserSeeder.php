<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        AdminUser::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            ['password' => Hash::make('superadmin123')]
        );
    }
}
