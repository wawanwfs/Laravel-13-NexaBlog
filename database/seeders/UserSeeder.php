<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Super Admin',
            'email'    => 'superadmin@nexablog.com',
            'password' => Hash::make('password'),
            'role'     => 'superadmin',
            'bio'      => 'Platform superadmin dengan akses penuh ke seluruh sistem NexaBlog.',
        ]);

        User::create([
            'name'     => 'Admin Blog',
            'email'    => 'admin@nexablog.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'bio'      => 'Administrator blog yang mengelola konten dan moderasi komentar.',
        ]);

        User::create([
            'name'     => 'John Doe',
            'email'    => 'user@nexablog.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'bio'      => 'Pembaca setia NexaBlog.',
        ]);

        User::create([
            'name'     => 'Jane Smith',
            'email'    => 'jane@nexablog.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'bio'      => 'Penggemar teknologi dan desain.',
        ]);
    }
}
