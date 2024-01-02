<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolesArray = [
        [
            'name' => 'admin',
        ],
        [
            'name' => 'user',
        ],
    ];

    foreach ($rolesArray as $role) {
            DB::table('roles')->insert(
                [
                    'name' => $role['name'],
                ]);
        }

    }
}
