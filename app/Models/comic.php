<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'author_id', 'image'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'comic_genre');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function synopsis()
    {
        return $this->hasOne(Synopsis::class);
    }
}
