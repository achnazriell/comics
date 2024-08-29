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
//hasMany digunakan ketika satu model memiliki banyak entri di model lain
//belongsTo untuk tabel yang memiliki kolom foreign key yang merujuk ke primary key di tabel lain
//fillable untuk untuk mendefinisikan atribut mana yang dapat diisi secara massal
//belongsToMany digunakan untuk mendefinisikan hubungan many-to-many (banyak-ke-banyak) antara dua model
