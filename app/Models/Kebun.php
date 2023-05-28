<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kebun extends Model
{
    use HasFactory;

    protected $table = 'kebuns';
    protected $fillable = [
        'nama_kebun',
        'lokasi_kebun',
        'id_user'
    ];

    //get all data from table which id_user corresponds with the specified id_user

    public function tertentu()
    {
        return $this->where('id_user', auth()->user()->id)->get();
    }


}
