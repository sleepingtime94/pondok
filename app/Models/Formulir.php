<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulir extends Model
{
    use HasFactory;

    // Menentukan secara eksplisit nama tabel yang benar
    protected $table = 'formulir';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array
     */
    protected $fillable = [
        'jenis_formulir',
        'keterangan',
        'dokumen',
        'aktif',
    ];
}