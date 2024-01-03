<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteMangaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $favoriteMangas= [
            [
                "user_id" => 1,
                "manga_id" => 1
            ],
            [
                "user_id" => 1,
                "manga_id" => 2
            ]
            ];

        foreach($favoriteMangas as $element){
            DB::table('favorite_manga')->insert(
            [
                'user_id'=> $element['user_id'],
                'manga_id'=> $element['manga_id']
            ]
            );
        }
    }
}