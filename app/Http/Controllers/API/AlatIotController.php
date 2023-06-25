<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Alat_IoT;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\Alatresource;

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
        $data = $alats->kebun($request->id_kebun);
        return response(['alats' => alatResource::collection($data), 'message' => "Data successfully retrieved"], 200);
    }

    public function all()
    {
        $alats = Alat_IoT::all();
        return response(['kebun' => Alatresource::collection($alats), 'message' => "Data successfully retrieved"], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created Alat in database.
     */
    public function store(Request $request) 
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id_kebun' => 'required|unique:alat__io_t_s,id_kebun',
        ]);

        if ($validator->fails()){
            return response(['error'=>$validator->errors(),'alat data not valid!']);
        }

        $alat = Alat_IoT::create($data);

        return response(["alats" => new alatResource($alat),'message'=> 'data successfully added'],200);//diwehi 200?
    }

    /**
     * Display the specified Alat that corresponds with the specified id.
     */
    public function show(Alat_IoT $alat)//string $id
    {
        return response(["alats" => new alatResource($alat),'message'=> 'data successfully retrieved'],200);//diwehi 200?
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified Alat that corresponds with the specified id in database.
     */
    public function update(Request $request, Alat_IoT $alat)
    {
        $alat->update($request->all());
        return response(["alats" => new alatResource($alat),'message'=> 'data successfully updated'],200);//diwehi 200?
    } 

    /**
     * Remove the specified Alat from database.
     */
    public function destroy(Alat_IoT $alat)
    {
        $alat->delete();
        return response(['message'=>'Data deleted']);
    }
}
