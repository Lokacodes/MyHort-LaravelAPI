<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\jadwalResource;
use App\Models\JadwalSiram;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

/**
 * @group JadwalSiram Management
 * 
 * APIs for managing JadwalSiram
 */

class JadwalSiramController extends Controller
{
    public function index(Request $request)
    {
        $alats = new JadwalSiram();
        $data = $alats->alat($request->id_alat);
        return response(['Jadwals' => jadwalResource::collection($data), 'message' => "Data successfully retrieved"], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function all()
    {
        $alats = JadwalSiram::all();
        return response(['kebun' => jadwalResource::collection($alats), 'message' => "Data successfully retrieved"], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['jam_on'] = strtotime($data['jam_on']);
        $data['jam_off'] = strtotime($data['jam_off']);
        $data['jam_on'] = date('H:i:s', $data['jam_on']);
        $data['jam_off'] = date('H:i:s', $data['jam_off']);

        if ($data['jam_on'] == $data['jam_off']) {
            return response(['message' => 'ON and OFF time cannot be the same'],401);
        }
        else if ($data['jam_on'] > $data['jam_off']) {
            return response(['message' => 'ON time cannot be greater than OFF time'],401);
        }

        $jadwalSiramObj = new JadwalSiram();
        $alljadwal = $jadwalSiramObj->alat($request->id_alat);
        
        foreach ($alljadwal as $jadwals){
            if ($data['jam_on'] == $jadwals['jam_on'] || $data['jam_off'] == $jadwals['jam_off']) {
                return response(['message' => 'This schedule is colliding with another schedule'],401);
            }

            else if ($data['jam_on'] > $jadwals['jam_on'] && $data['jam_on'] < $jadwals['jam_off']) {
                return response(['message' => 'There is already a schedule in this time'],401);
            }

            else if ($data['jam_off'] > $jadwals['jam_on'] && $data['jam_off'] < $jadwals['jam_off']) {
                return response(['message' => 'There is already a schedule in this time'],401);
            }

            else if ($data['jam_on'] < $jadwals['jam_on'] && $data['jam_off'] > $jadwals['jam_off']) {
                return response(['message' => 'This schedule is colliding with another schedule'],401);
            }
        }
        
        $validator = Validator::make($data, [
            'id_alat' => 'required',
            'jam_on' => 'required',
            'jam_off' => 'required',
        ]);

        if ($validator->fails()){
            return response(['error'=>$validator->errors(),'jadwal data not valid!']);
        }

        $alat = JadwalSiram::create($data);

        return response(["jadwal" => new jadwalResource($alat),'message'=> 'data successfully added'],200);//diwehi 200?
    }

    /**
     * Display the specified Alat that corresponds with the specified id.
     */
    public function show(JadwalSiram $jadwal)//string $id
    {
        return response(["jadwal" => new jadwalResource($jadwal),'message'=> 'data successfully retrieved'],200);//diwehi 200?
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
    public function update(Request $request, JadwalSiram $jadwal)
    {
        $data = $request->all();
        $data['jam_on'] = strtotime($data['jam_on']);
        $data['jam_off'] = strtotime($data['jam_off']);
        $data['jam_on'] = date('H:i:s', $data['jam_on']);
        $data['jam_off'] = date('H:i:s', $data['jam_off']);

        if ($data['jam_on'] == $data['jam_off']) {
            return response(['message' => 'ON and OFF time cannot be the same'],401);
        }

        $jadwalSiramObj = new JadwalSiram();
        $alljadwal = $jadwalSiramObj->alat($request->id_alat);
        
        foreach ($alljadwal as $jadwals){
            if ($data['jam_on'] == $jadwals['jam_on'] || $data['jam_off'] == $jadwals['jam_off']) {
                return response(['message' => 'This schedule is colliding with another schedule'],401);
            }

            else if ($data['jam_on'] > $jadwals['jam_on'] && $data['jam_on'] < $jadwals['jam_off']) {
                return response(['message' => 'There is already a schedule in this time'],401);
            }

            else if ($data['jam_off'] > $jadwals['jam_on'] && $data['jam_off'] < $jadwals['jam_off']) {
                return response(['message' => 'There is already a schedule in this time'],401);
            }

            else if ($data['jam_on'] < $jadwals['jam_on'] && $data['jam_off'] > $jadwals['jam_off']) {
                return response(['message' => 'This schedule is colliding with another schedule'],401);
            }
        }

        $jadwal->update($request->all());
        return response(["alats" => new jadwalResource($jadwal),'message'=> 'data successfully updated'],200);//diwehi 200?
    } 

    /**
     * Remove the specified Alat from database.
     */
    public function destroy(JadwalSiram $jadwal)
    {
        $jadwal->delete();
        return response(['message'=>'Data deleted']);
    }
}
