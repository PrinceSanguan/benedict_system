<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'firstname' => 'Admin',
                'lastname' => 'Admin',
                'role_id' => '1',
                'email' => 'admin@gmail.com',
                'password' => '$2y$12$8qGbpTMe/NFXUMNZbMB5Gu0SFlp/hOcbGb6yyhSdn6MxedBmK7Eta',
                'remember_token' => NULL,
                'created_at' => '2024-09-05 06:32:55',
                'updated_at' => '2024-09-05 06:32:55'
            ),
            1 => 
            array (
                'id' => 2,
                'firstname' => 'EMU',
                'lastname' => 'EMU',
                'role_id' => '5',
                'email' => 'emu@gmail.com',
                'password' => '$2y$12$8qGbpTMe/NFXUMNZbMB5Gu0SFlp/hOcbGb6yyhSdn6MxedBmK7Eta',
                'remember_token' => NULL,
                'created_at' => '2024-09-05 06:32:55',
                'updated_at' => '2024-09-05 06:32:55'
            ),
            2 => 
            array (
                'id' => 3,
                'firstname' => 'GSO',
                'lastname' => 'GSO',
                'role_id' => '6',
                'email' => 'gso@gmail.com',
                'password' => '$2y$12$8qGbpTMe/NFXUMNZbMB5Gu0SFlp/hOcbGb6yyhSdn6MxedBmK7Eta',
                'remember_token' => NULL,
                'created_at' => '2024-09-05 06:32:55',
                'updated_at' => '2024-09-05 06:32:55'
            ),

        ));
    }
}
