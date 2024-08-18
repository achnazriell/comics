<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address'];

    // Mendefinisikan relasi satu-ke-banyak dengan Comic
    public function comics()
    {
        return $this->hasMany(Comic::class);
    }
}
