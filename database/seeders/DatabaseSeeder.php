<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create Roles
        $roles = ['admin', 'speaker', 'sponsor', 'visitor', 'moderator'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'full_name' => 'Admin User',
                'nickname' => 'admin',
                'password' => Hash::make('password'),
                'institution' => 'Admin Institution',
                'address' => 'Admin Address',
                'country' => 'Admin Country',
                'state' => 'Admin State',
            ]
        );
        $admin->assignRole('admin');

        // Create Visitor User
        $visitor = User::firstOrCreate(
            ['email' => 'visitor@example.com'],
            [
                'full_name' => 'Visitor User',
                'nickname' => 'visitor',
                'password' => Hash::make('password'),
                'institution' => 'Visitor Institution',
                'address' => 'Visitor Address',
                'country' => 'Visitor Country',
                'state' => 'Visitor State',
            ]
        );
        $visitor->assignRole('visitor');
    }
}
