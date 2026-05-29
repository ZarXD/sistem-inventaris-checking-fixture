<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CheckingFixture;

class LokasiRak extends Model
{
    protected $table = 'lokasi_raks';

    protected $fillable = [
        'nama_rak',
        'area_ruangan',
    ];

    public function checkingFixtures()
    {
        return $this->hasMany(CheckingFixture::class, 'lokasi_rak_id');
    }
}
