<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rekap extends Model
{
    use HasFactory;

    protected $table = 'rekaps';
    protected $guarded = [
        'id',
        'timestamps'
    ];

    public function alat_iot()
    {
        return $this->belongsTo(Alat_IoT::class, 'id_alat');
    }
}
