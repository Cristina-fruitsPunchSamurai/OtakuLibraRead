<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MangasTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mangasTagsArray = [
            [
                'manga_id' => 1,
                'tag_id' => 1,
            ],
            [
                'manga_id' => 2,
                'tag_id' => 2,
            ],
            [
                'manga_id' => 3,
                'tag_id' => 3,
            ],
            [
                'manga_id' => 4,
                'tag_id' => 4,
            ],
            [
                'manga_id' => 5,
                'tag_id' => 5,
            ],
            [
                'manga_id' => 4,
                'tag_id' => 7,
            ],
            ];

            foreach ($mangasTagsArray as $element) {
                DB::table('mangas_tags')->insert(
                    [
                        'manga_id' => $element['manga_id'],
                        'tag_id' => $element['tag_id'],
                    ]);
            }
    }
}
