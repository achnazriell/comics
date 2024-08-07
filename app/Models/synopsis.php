<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Synopsis extends Model
{
    use HasFactory;

    protected $fillable = ['comic_id', 'synopsis'];

    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }
}

