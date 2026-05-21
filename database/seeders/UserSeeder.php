<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nama' => 'Subbagian program dan keuangan',
                'username' => 'progkeu',
            ],
            [
                'nama' => 'Subbagian tata usaha',
                'username' => 'tu',
            ],
            [
                'nama' => 'Kasi pelayanan',
                'username' => 'pelayanan',
            ],
            [
                'nama' => 'Kasi pemerintahan',
                'username' => 'pemerintahan',
            ],
            [
                'nama' => 'Kasi ketentraman dan ketertiban',
                'username' => 'trantib',
            ],
            [
                'nama' => 'Kasi pembangunan dan pemberdayaan masyarakat',
                'username' => 'bangdaya',
            ],
        ];

        User::create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('123'),
            'role' => 'admin',
        ]);
        foreach ($users as $user) {
            User::create([
                'nama' => $user['nama'],
                'username' => $user['username'],
                'password' => Hash::make('123'),
                'role' => 'unit pengolah',
            ]);
        }
    }
}
