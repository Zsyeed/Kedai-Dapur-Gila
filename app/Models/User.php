<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'kode_user',
        'nama',
        'email',
        'password',
        'role',
        'no_telepon',
        'alamat',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Otomatis generate kode_user saat user dibuat.
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->kode_user)) {
                $user->kode_user = self::generateKodeUser($user->role);
            }
        });
    }

    /**
     * Generate kode user berdasarkan role.
     *
     * admin     -> ADM001
     * owner     -> OWN001
     * pelanggan -> PLG001
     */
    public static function generateKodeUser(string $role): string
    {
        // Tentukan prefix berdasarkan role
        $prefix = match ($role) {
            'admin'     => 'ADM',
            'owner'     => 'OWN',
            'pelanggan' => 'PLG',
            default     => 'PLG',
        };

        // Ambil user terakhir dengan role yang sama
        $lastUser = self::where('role', $role)
            ->orderBy('id', 'desc')
            ->first();

        // Tentukan nomor urut
        if (!$lastUser || !$lastUser->kode_user) {
            $number = 1;
        } else {
            // Ambil angka setelah prefix
            // ADM001 -> 001
            // OWN012 -> 012
            // PLG125 -> 125
            $number = (int) substr($lastUser->kode_user, 3) + 1;
        }

        // Hasil akhir: ADM001, OWN001, PLG001
        return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    /* ---------- Relasi ---------- */

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    /* ---------- Helper ---------- */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    public function isPelanggan(): bool
    {
        return $this->role === 'pelanggan';
    }

    public function getTotalKeranjangAttribute(): int
    {
        return $this->keranjang->sum('jumlah');
    }
}