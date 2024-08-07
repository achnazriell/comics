<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = ['comic_id', 'title', 'number'];

    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }
}

