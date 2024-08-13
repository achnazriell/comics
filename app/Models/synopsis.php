<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Synopsis extends Model
{
    use HasFactory;

    protected $fillable = ['comic_id', 'content'];

    // Specify the table name if it does not follow the default plural convention
    protected $table = 'synopsis'; 

    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }
}
