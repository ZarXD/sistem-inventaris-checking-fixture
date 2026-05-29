<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CheckingFixture;
use App\Models\User;

class RiwayatTransaksi extends Model
{
    protected $table = 'riwayat_transaksis';

    protected $fillable = [
        'cf_id',
        'user_id',
        'jenis_transaksi',
        'tanggal_transaksi',
    ];

    public function checkingFixture()
    {
        return $this->belongsTo(CheckingFixture::class, 'cf_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
