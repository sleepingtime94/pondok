<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    use HasFactory;

    protected $table = 'konsultasi';

    // Menonaktifkan timestamps karena tabel tidak memiliki created_at dan updated_at
    public $timestamps = false;

    // Laravel tidak akan mengelola primary key secara otomatis, karena bukan integer
    public $incrementing = false;

    // Primary key adalah string
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_konsul',
        'id_jenis',
        'nik',
        'nama',
        'no_hp',
        'isi_pengaduan',
        'dok_dukung1',
        'dok_dukung2',
        'dok_dukung3',
        'dok_dukung4',
        'dok_dukung5',
        'dok_dukung6',
        'respon_awal',
        'solusi',
        'status',
        'tgl_pengaduan',
        'jam_pengaduan',
        'tgl_respon',
        'jam_respon',
        'tgl_selesai',
        'jam_selesai',
        'user_respon',
        'user_selesai'
    ];
}