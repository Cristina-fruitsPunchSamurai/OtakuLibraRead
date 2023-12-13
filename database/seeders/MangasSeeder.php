<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MangasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mangasArray = [
        [
            'title' => 'One Piece',
            'status' => 'ongoing',
            'description' => 'loremipsum',
            'picture' =>'https://www.manga-news.com/public/images/series/.one-piece-manga-1-glenat_large.jpg',
        ],
        [
            'title' => 'Berserk',
            'status' => 'ongoing',
            'description' => 'loremipsum',
            'picture' =>'https://www.manga-news.com/public/images/series/.berserk-2016-1-glenat_large.jpg',
        ],
        [
            'title' => 'Saezuru Tori wa Habatakanai',
            'status' => 'ongoing',
            'description' => 'loremipsum',
            'picture' =>'https://www.manga-news.com/public/images/series/.twittering-birds-never-fly-taifu_large.jpg',
        ],
        [
            'title' => 'Akatsuki no Yonao',
            'status' => 'ongoing',
            'description' => 'loremipsum',
            'picture' =>'https://www.manga-news.com/public/images/vols/Akatsuki-no-Yona-34-jp.jpg',
        ],
        [
            'title' => 'Yukibana no Tora',
            'status' => 'completed',
            'description' => 'loremipsum',
            'picture' =>'https://www.manga-news.com/public/images/series/.tigre-des-neiges-1-lezard-noir_large.jpg',
        ],
    ];
        foreach ($mangasArray as $manga) {
            DB::table('mangas')->insert(
                [
                    'title' => $manga['title'],
                    'status' => $manga['status'],
                    'description' => $manga['description'],
                    'picture' => $manga['picture'],
                ]);
        }
    }
}
