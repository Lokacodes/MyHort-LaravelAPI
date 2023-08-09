<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Alat_IoT;
use App\Models\JadwalSiram;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\AlatResource;
use App\Http\Resources\jadwalResource;

/**
 * @group Alat_IoT Management
 * 
 * APIs for managing Alat_IoT
 */

class AlatIotController extends Controller
{
    /**
     * Display a listing of the Alat_IoT that corresponds with the specified kebun.
     */
    public function index(Request $request)
    {
        $alats = new Alat_IoT;
        $jadwals = new JadwalSiram;
        $data = $alats->kebun($request->id_alat);
        $jadwal = $jadwals->alat($request->id_alat); 
        $dataLength = count($data);
        if ($dataLength == 0) {
            return response(['message'=> 'garden not found'],404);
        }
        return response(['alats' => AlatResource::collection($data), 'jadwals' => jadwalResource::collection($jadwal), 'message' => "Data successfully retrieved"], 200);
    }

    public function all()
    {
        $alats = Alat_IoT::all();
        return response(['kebun' => AlatResource::collection($alats), 'message' => "Data successfully retrieved"], 200);
    }

    /**
     * Store a newly created Alat in database.
     */
    public function store(Request $request) 
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id_alat' => 'required|unique:alat__io_t_s,id_alat',
        ]);

        if ($validator->fails()){
            return response(['error'=>$validator->errors(),'alat data not valid!']);
        }

        $alat = Alat_IoT::create($data);

        return response(["alats" => new AlatResource($alat),'message'=> 'data successfully added'],200);//diwehi 200?
    }

    public function show(Alat_IoT $alat_IoT)//string $id
    {
        $alats = new Alat_IoT;
        $data = $alats->cariAlat($alat_IoT);
        if ($data === null) {
            return response(['message'=> $data],404);
        }
        return response(["alats" => new AlatResource($data),'message'=> 'data successfully retrieved'],200);//diwehi 200?
    }

    public function update(Request $request)
    {
        $alat = new Alat_IoT;
        $data = $alat->cariAlat($request->id_alat);
        if ($data === null) {
            return response(['message'=> 'data not found'],404);
        }
        // return response(["alats"=> $data],200);
        $data->update($request->all());
        return response(["alats" => new AlatResource($data),'message'=> 'data successfully updated'],200);//diwehi 200?
    } 

    /**
     * Remove the specified Alat from database.
     */
    public function destroy(Request $request)
    {
        $alat = new Alat_IoT;
        $data = $alat->cariAlat($request->id_alat);
        if ($data === null) {
            return response(['message'=> 'data not found'],404);
        }
        $data->delete();
        return response(['message'=>'Data deleted']);
    }
}
