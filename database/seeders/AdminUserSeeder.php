<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'email' => 'superadmin@gmail.com',
                'password' => 'superadmin123',
                'role' => 'superadmin',
            ],
            [
                'email' => 'adminkompu@gmail.com',
                'password' => 'adminkompu123',
                'role' => 'kompu',
            ],
            [
                'email' => 'adminlayananteknis@gmail.com',
                'password' => 'adminlayananteknis123',
                'role' => 'layanan_teknis',
            ],
        ];

        foreach ($users as $user) {
            AdminUser::updateOrCreate(
                ['email' => $user['email']],
                [
                    'password'  => Hash::make($user['password']),
                    'role'      => $user['role'],
                    'is_active' => true,
                ]
            );
        }
    }
}
