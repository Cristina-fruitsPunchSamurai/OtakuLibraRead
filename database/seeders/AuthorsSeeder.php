<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorsSeeder extends Seeder
{
    public function run(): void
    {

        $authorsArray = [
        [
            'firstname' => 'Eiichiro',
            'lastname' => 'Oda',
        ],
        [
            'firstname' => 'Kentaro',
            'lastname' => 'Miura',
        ],
        [
            'firstname' => 'Kou',
            'lastname' => 'Yoneda',
        ],
        [
            'firstname' => 'Mizuho',
            'lastname' => 'Kusanagi',
        ],
        [
            'firstname' => 'Akiko',
            'lastname' => 'Higashimura',
        ]
    ];

        foreach ($authorsArray as $author) {
            DB::table('authors')->insert(
                [
                    'firstname' => $author['firstname'],
                    'lastname' => $author['lastname'],
                ]);
        }
    }
}