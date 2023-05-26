<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat_IoT extends Model
{
    use HasFactory;

    protected $table = 'alat__io_t_s';
    protected $guarded = [
        'id',
        'timestamps'
    ];

    public function kebun()
    {
        return $this->belongsTo(Kebun::class, 'id_kebun');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }


}
