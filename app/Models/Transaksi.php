<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'kode_transaksi',
        'total_harga',
        'status',
        'metode_pembayaran',
        'nomor_va',           
        'alamat_pengiriman',
        'no_telepon',     
        'catatan',
        'bukti_pembayaran',
    ];

    protected function casts(): array
    {
        return [
            'total_harga' => 'integer',
        ];
    }

    /* ---------- Relasi ---------- */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    /* ---------- Accessor ---------- */

    public function getTotalHargaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu'   => 'Menunggu',
            'diproses'   => 'Diproses',
            'diantar'    => 'Sedang Dikirim',
            'selesai'    => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default      => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'menunggu'   => 'warning',
            'diproses'   => 'info',
            'diantar'    => 'info',
            'selesai'    => 'success',
            'dibatalkan' => 'danger',
            default      => 'neutral',
        };
    }

    /* ---------- Static helper ---------- */

    public static function generateKode(): string
    {
        $last = self::orderBy('id', 'desc')->first();
        $num  = $last ? ((int) substr($last->kode_transaksi, -4)) + 1 : 1;

        return 'DPG-' . date('Ymd') . '-' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate nomor Virtual Account unik.
     *
     * Contoh:
     * BCA     : 014xxxxxxxxxxxx
     * BNI     : 009xxxxxxxxxxxx
     * Mandiri : 008xxxxxxxxxxxx
     */
    public static function generateNomorVA(string $bank = 'bca'): string
    {
        $prefix = match (strtolower($bank)) {
            'bca'     => '014',
            'bni'     => '009',
            'mandiri' => '008',
            default   => '999',
        };

        do {
            // Contoh hasil:
            // 014202605192051123
            $nomorVA = $prefix
                . now()->format('YmdHis')
                . random_int(100, 999);
        } while (self::where('nomor_va', $nomorVA)->exists());

        return $nomorVA;
    }
}