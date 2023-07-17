<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSiram extends Model
{
    use HasFactory;

    protected $table = 'jadwal_sirams';

    protected $guarded = [
        'id',
        'timestamps'
    ];

    // protected $casts = [
    //     'jam_on' => 'datetime:H:i',
    //     'jam_off' => 'datetime:H:i',
    // ];

    public function alat($id_alat)
    {
        return $this->where('id_alat', $id_alat)->take(4)->get();
    }
}
