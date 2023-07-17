<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Kebun;
use App\Models\Alat_IoT;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\KebunResource;

/**
 * @group Kebun Management
 * 
 * APIs for managing kebun
 */

class KebunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kebuns = new Kebun;
        $data = $kebuns->tertentu();
        return response(['kebun' => KebunResource::collection($data), 'message' => "Data successfully retrieved"], 200);
    }

    public function all()
    {
        $kebuns = kebun::all();
        return response(['kebun' => KebunResource::collection($kebuns), 'message' => "Data successfully retrieved"], 200);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $this->checkIDAlat($request);

        $validator = Validator::make($data, [
            'nama_kebun' => 'required|max:255',
            'lokasi_kebun' => 'required|max:255',
            'id_user' => 'required',
            'id_alat' => 'required|unique:kebuns',
        ]);

        if ($validator->fails()){
            return response(['message'=>$validator->errors()],403);
        }

        $kebun = Kebun::create($data);

        return response(["kebun" => new KebunResource($kebun),'message'=> 'data successfully added'],200);//diwehi 200?
    }

    public function checkIDAlat(Request $request)
    {
        $data = $request->all();

        $id_alat = $data['id_alat'];

        $kebun = new Kebun;
        $IoT = new Alat_IoT;

        $alatKebun = $kebun->IDAlat($id_alat);
        $alatIoT = $IoT->IDAlat($id_alat);
        
        if ($alatKebun != null && $alatIoT != null) {
            return response(['message'=>'id alat already used'],403);
        } else if ($alatIoT == null) {
            return response(['message'=>'id alat is not registered'],403);
        }

        return response(['message'=>'id alat can be used'],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kebun $kebun)//string $id
    {
        return response(["kebun" => new KebunResource($kebun),'message'=> 'data successfully retrieved'],200);//diwehi 200?
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kebun $kebun)
    {
        $kebun->update($request->all());
        return response(["kebun" => new KebunResource($kebun),'message'=> 'data successfully updated'],200);//diwehi 200?
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kebun $kebun)
    {
        $kebun->delete();
        return response(['message'=>'Data deleted']);
    }
}
