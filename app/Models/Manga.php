<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

//pour créer un modèle : php artisan make:model Post -m
class Manga extends Model
{
    use HasFactory;
// Seuls les attributs répertoriés dans le tableau fillable seront autorisés à être remplis en masse à l'aide des méthodes create ou update
    protected $fillable = [
        'title',
        'status',
        'description',
        'picture',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class,'authors_mangas');
    }


    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'mangas_tags');
    }

    public function addToFavoriteBy(): BelongsToMany
    {
        //  la méthode BelongsToMany attend 4 paramètres dont nom de la table pivot, $foreignPivotKey et $relatedPivotKey = null,
        //!!!! Faire bien attention à l'ordre des paramètres!!!!
        return $this->belongsToMany(User::class, 'favorite_manga','manga_id', 'user_id')
        ->withTimestamps();

    }
}
