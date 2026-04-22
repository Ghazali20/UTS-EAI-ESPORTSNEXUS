<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    // Nama tabel di database
    protected $table = 'players';

    /**
     * Kolom yang boleh diisi (Mass Assignment)
     * Tambahkan 'id' ke dalam list agar kita bisa input manual
     */
    protected $fillable = ['id', 'name', 'nickname', 'game_type', 'rank', 'favorite_club'];

    /**
     * Beritahu Laravel bahwa kita akan mengontrol Primary Key secara manual
     * jika diperlukan (untuk fitur "Fill the Gap" ID yang kamu mau).
     */
    public $incrementing = true;
}