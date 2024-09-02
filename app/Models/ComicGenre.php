<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComicGenre extends Model
{
    use HasFactory;

    protected $table = 'comic_genre';

    protected $fillable = ['comic_id', 'genre_id'];

    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}

