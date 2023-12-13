<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorsMangasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authorsMangasArray = [
            [
                'manga_id' => 1,
                'author_id' => 1,
            ],
            [
                'manga_id' => 2,
                'author_id' => 2,
            ],
            [
                'manga_id' => 3,
                'author_id' => 3,
            ],
            [
                'manga_id' => 4,
                'author_id' => 4,
            ],
            [
                'manga_id' => 5,
                'author_id' => 5,
            ],
        ];

        foreach ($authorsMangasArray as $element) {
            DB::table('authors_mangas')->insert(
                [
                    'manga_id' => $element['manga_id'],
                    'author_id' => $element['author_id'],
                ]);
        }
    }
}
