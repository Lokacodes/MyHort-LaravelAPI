<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat_IoT extends Model
{
    use HasFactory;

    protected $table = 'alat__io_t_s'; //table name in migration
    protected $guarded = [ //the field that cannot be mass assigned / the opposite of fillable
        'id',
        'timestamps'
    ];

    // to get all data from table which id_kebun corresponds with the specified id_kebun
    public function kebun($id_alat) 
    {
        return $this->where('id_alat', $id_alat)->get();
    }

    public function cariAlat($id_alat){
        return $this->where('id_alat', $id_alat)->first();
    }

    public function IDAlat(String $id_alat){
        return $this->where('id_alat', $id_alat)->first();
    }


}
