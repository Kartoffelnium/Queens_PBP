<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Pelanggan;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($nama)
    {
        $pelanggan = Pelanggan::where('nama_pelanggan', $nama_pelanggan) -> first();

        if($pelanggan !== null){
            return response([
                'message' => 'Retrieve Success',
                'data' => $pelanggan
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_pelanggan'        => 'required|max:255',
            'jenis_room'            => 'required|max255',
            'tanggal'               => 'required|date',
            'jml_orang_dewasa'      => 'required|numeric',
            'jml_anak_kecil'        => 'required|numeric',

            
        ]);

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400);
        }

        $pelanggan = Pelanggan::create($storeData);
        return response([
            'message'   => 'Add Pelanggan Success',
            'data'      => $pelanggan
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::find($id);
        if(is_null($pelanggan)){
            return response([
                'message' => 'pelanggan Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_pelanggan'        => 'required|max:255',
            'jenis_room'            => 'required|max255',
            'tanggal'               => 'required|date',
            'jml_orang_dewasa'      => 'required|numeric',
            'jml_anak_kecil'        => 'required|numeric',
        ]);

        if($validate->fails()){
            return response(['message' => $validate-errors()], 400);
        }

        $pelanggan->nama_pelanggan = $updateData['nama_pelanggan'];
        $pelanggan->jenis_room = $updateData['jenis_room'];
        $pelanggan->tanggal = $updateData['tanggal'];
        $pelanggan->jml__orang_dewasa = $updateData['jml_orang_dewasa'];
        $pelanggan->jml_anak_kecil = $updateData['jml_anak_kecil'];
        

        if($pelanggan->save()){
            return response([
                'message' => 'Update Pelanggan Success',
                'data' => $pelanggan
            ], 200);
        }

        return response([
            'message' => 'Update Pelanggan Failed',
            'data' => null
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pelanggan = Pelanggan::find($id);

        if(is_null($pelanggan)){
            return response([
                'message' => 'Pelanggan Not Found',
                'data' => null
            ], 404);
        }

        if($pelanggan->delete()){
            return response([
                'message' => 'Delete Pelanggan Success',
                'data' => $pelanggan
            ], 200);
        }

        return response([
            'message' => 'Delete Pelanggan Failed',
            'data' => null
        ], 400);
    }
}
