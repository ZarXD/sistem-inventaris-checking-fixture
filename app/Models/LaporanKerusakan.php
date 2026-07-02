<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKerusakan extends Model
{
    protected $table = 'laporan_kerusakans';

    protected $fillable = [
        'cf_id',
        'user_id',
        'keterangan',
        'foto_path',
        'status',
        'catatan_admin',
    ];

    public function checkingFixture()
    {
        return $this->belongsTo(CheckingFixture::class, 'cf_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted()
    {
        static::updated(function ($laporan) {
            if ($laporan->isDirty('status')) {
                $cf = $laporan->checkingFixture;
                if (!$cf) return;

                // Jika admin merubah status laporan menjadi 'Diproses', otomatis CF jadi 'Perbaikan'
                if ($laporan->status === 'Diproses' && $cf->status_ketersediaan !== 'Perbaikan') {
                    $cf->update(['status_ketersediaan' => 'Perbaikan']);

                    \App\Models\RiwayatTransaksi::create([
                        'cf_id'             => $cf->id,
                        'user_id'           => auth()->id() ?? 1,
                        'jenis_transaksi'   => 'Perbaikan',
                        'tanggal_transaksi' => now(),
                    ]);
                } 
                // Jika admin merubah status laporan menjadi 'Selesai', otomatis CF jadi 'Tersedia'
                elseif ($laporan->status === 'Selesai' && $cf->status_ketersediaan !== 'Tersedia') {
                    $cf->update(['status_ketersediaan' => 'Tersedia']);

                    \App\Models\RiwayatTransaksi::create([
                        'cf_id'             => $cf->id,
                        'user_id'           => auth()->id() ?? 1,
                        'jenis_transaksi'   => 'Tersedia',
                        'tanggal_transaksi' => now(),
                    ]);
                }
            }
        });
    }
}
