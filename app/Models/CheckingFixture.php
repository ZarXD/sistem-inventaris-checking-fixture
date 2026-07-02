<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LokasiRak;

class CheckingFixture extends Model
{
    protected $table = 'checking_fixtures';

    protected $fillable = [
        'part_number',
        'customer',
        'nama_cf',
        'status_ketersediaan',
        'lokasi_rak_id',
        'image',
    ];

    public function lokasiRak()
    {
        return $this->belongsTo(LokasiRak::class, 'lokasi_rak_id');
    }
}
