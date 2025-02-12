<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author_id', 'synopsis', 'publisher_id', 'image','chapter_id', 'chapter_images'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'comic_genre');
    }

    public function synopsis()
    {
        return $this->hasOne(Synopsis::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}