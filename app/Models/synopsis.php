<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Synopsis extends Model
{
    use HasFactory;

    protected $table = 'synopsis';  // This should match your migration table name

    protected $fillable = ['comic_id', 'content'];

    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }
}
