<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['comic_id', 'publisher_id', 'review', 'rating'];

    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
}
