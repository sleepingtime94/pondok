<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\JenisPelayanan;
use App\Models\Pengambilan;
use App\Models\UserSyarat; 

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_trx';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_trx', 'id_user', 'nik', 'kk', 'nama', 'jenis_layanan',
        'id_dokumen', 'pengambilan_id', 'keterangan', 'tgl', 'status',
        'id_kec','id_kel','tgl_respon', 'tgl_proses', 'tgl_selesai', 'konfirmasi', 'tgl_konfirmasi', 'pesan', 'alasan',
        'rating', 'komentar_rating', 'tgl_rating',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function dokumen(): BelongsTo
    {
        return $this->belongsTo(JenisPelayanan::class, 'id_dokumen', 'id'); 
    }

    public function pengambilan(): BelongsTo
    {
        return $this->belongsTo(Pengambilan::class, 'pengambilan_id', 'id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(UserSyarat::class, 'id_trx', 'id_trx');
    }

    public function jenisPelayanan()
    {
        return $this->belongsTo(JenisPelayanan::class, 'id_dokumen', 'id');
    }

    public function userDokumen()
    {
        // return $this->hasMany(\App\Models\UserDokumen::class, 'id_trx', 'id_trx');
        return $this->hasMany(UserDokumen::class, 'id_trx', 'id_trx');
    }

    // ✅ Definisi status sebagai konstanta
    public const STATUS_BARU = 1;
    public const STATUS_VERIFIKASI = 2;
    public const STATUS_PROSES = 3;
    public const STATUS_SELESAI = 4;
    public const STATUS_DITOLAK = 5;
    public const STATUS_AJUKAN_ULANG = 6;
    public const STATUS_KOMPLAIN = 7;
    public const STATUS_DIBATALKAN = 8;

    // ✅ Mapping angka ke label
    public static function statusLabels()
    {
        return [
            self::STATUS_BARU => 'Baru',
            self::STATUS_VERIFIKASI => 'Verifikasi',
            self::STATUS_PROSES => 'Proses',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DITOLAK => 'Ditolak',
            self::STATUS_AJUKAN_ULANG => 'Pengajuan Ulang',
            self::STATUS_KOMPLAIN => 'Komplain',
            self::STATUS_DIBATALKAN => 'Dibatalkan',
        ];
    }

    // ✅ Accessor: dapatkan label status dari angka
    public function getStatusLabelAttribute()
    {
        return self::statusLabels()[$this->status] ?? 'Tidak Diketahui';
    }

    // ✅ Accessor: dapatkan warna badge Bootstrap sesuai status
    public function getStatusBadgeClassAttribute()
    {
        $badgeMap = [
            self::STATUS_BARU => 'badge-warning',
            self::STATUS_VERIFIKASI => 'badge-secondary',
            self::STATUS_PROSES => 'badge-primary',
            self::STATUS_SELESAI => 'badge-success',
            self::STATUS_DITOLAK => 'badge-danger',
            self::STATUS_AJUKAN_ULANG => 'badge-secondary',
            self::STATUS_KOMPLAIN => 'badge-danger',
            self::STATUS_DIBATALKAN => 'badge-danger',
        ];
        return $badgeMap[$this->status] ?? 'badge-light';
    }
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function statusLogs()
    {
        // return $this->hasMany(StatusLog::class, 'transaksi_id')->orderBy('created_at', 'desc');
        return $this->hasMany(StatusLog::class, 'transaksi_id', 'id_trx');
    }
}