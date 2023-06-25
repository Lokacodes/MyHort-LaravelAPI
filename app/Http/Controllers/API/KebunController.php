<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Kebun;
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

        $validator = Validator::make($data, [
            'nama_kebun' => 'required|max:255',
            'lokasi_kebun' => 'required|max:255',
            'id_user' => 'required',
        ]);

        if ($validator->fails()){
            return response(['error'=>$validator->errors(),'kebun data not valid!']);
        }

        $kebun = Kebun::create($data);

        return response(["kebun" => new KebunResource($kebun),'message'=> 'data successfully added'],200);//diwehi 200?
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
