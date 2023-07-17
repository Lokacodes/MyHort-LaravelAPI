<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kebun extends Model
{
    use HasFactory;

    protected $table = 'kebuns';
    protected $guarded = [
        'id',
        'timestamps'
    ];

    //get all data from table which id_user corresponds with the specified id_user

    public function tertentu()
    {
        return $this->where('id_user', auth()->user()->id)->get();
    }

    public function IDAlat(String $id_alat){
        return $this->where('id_alat', $id_alat)->first();
    }


}
