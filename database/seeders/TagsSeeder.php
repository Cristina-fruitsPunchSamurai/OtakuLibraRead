<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $tagsArray = [
        [
            'name' => 'shōnen',
        ],
        [
            'name' => 'seinen',
        ],
        [
            'name' => 'yaoi',
        ],
        [
            'name' => 'shōjo',
        ],
        [
            'name' => 'josei',
        ],
        [
            'name' => 'omegaverse',
        ],
        [
            'name' => 'fantasy',
        ],
    ];
        foreach ($tagsArray as $tag) {
            DB::table('tags')->insert(
                [
                    'name' => $tag['name'],
                ]);
        }
    }
}
