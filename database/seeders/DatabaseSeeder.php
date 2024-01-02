<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AuthorsSeeder;
use Database\Seeders\TagsSeeder;
use Database\Seeders\MangasSeeder;
use Database\Seeders\AuthorsMangasSeeder;
use Database\Seeders\MangasTagsSeeder;
use Database\Seeders\RolesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ici, on appelle les seeders que l'on a créés. 'php artisan db:seed'
     */
    public function run(): void
    {
        $this->call([
        AuthorsSeeder::class,
        TagsSeeder::class,
        MangasSeeder::class,
        AuthorsMangasSeeder::class,
        MangasTagsSeeder::class,
        RolesSeeder::class,
    ]);
    }
}
