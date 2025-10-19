<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    const TABLE_NAME = 'users';
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [   
                'name' => 'jdecsadmin',
                'firstname' => 'JDECS',
                'lastname' => 'Admin',
                'username' => 'jdecsadmin',
                'email' => 'system@jdecs.com',
                'password' => Hash::make('jdecsadmin123!'),
            ]
        ];

        foreach ($data as $userData) {
            DB::table(self::TABLE_NAME)->insert($userData);
        }
    }
}
