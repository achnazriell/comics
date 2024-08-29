<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = ['comic_id', 'title',];

    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }

    public function chapterImages()
    {
    return $this->hasMany(ChapterImage::class);
    }


    // Chapter.php
    public function images()
    {
    return $this->hasMany(ChapterImage::class);
    }


}
