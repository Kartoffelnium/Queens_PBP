<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $room = Room::all();

        if(count($room) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $room
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
            'jenis_kamar'    => 'required|max:60',
            'harga_kamar'    => 'required|numeric',
            'layanan'        => 'required|max:255',
            'image_kamar'    => 'string|max:255|nullable',
            

          
        ]);

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400);
        }

        $room = Room::create($storeData);
        return response([
            'message'   => 'Add room Success',
            'data'      => $room
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
        $room = Room::find($id);

        if(!is_null($room)){
            return response([
                'message' => 'Retrieve room Success',
                'data' => $room
            ], 200);
        }

        return response([
            'message' => 'Room Not Found',
            'data' => null
        ], 404);
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
        $room = room::find($id);
        if(is_null($room)){
            return response([
                'message' => 'Room Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'jenis_kamar'    => 'required|max:60',
            'harga_kamar'    => 'required|numeric',
            'layanan'        => 'required|max:255',
            'image_kamar'    => 'string|max:255|nullable',
        ]);

        if($validate->fails()){
            return response(['message' => $validate-errors()], 400);
        }

        $room->jenis_kamar = $updateData['jenis_kamar'];
        $room->harga_kamar = $updateData['harga_kamar'];
        $room->layanan = $updateData['layanan' ];
        $room->image_kamar = $updateData['image_kamar'];

        if($room->save()){
            return response([
                'message' => 'Update Room Success',
                'data' => $room
            ], 200);
        }

        return response([
            'message' => 'Update Room Failed',
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
        $room = room::find($id);

        if(is_null($room)){
            return response([
                'message' => 'Room Not Found',
                'data' => null
            ], 404);
        }

        if($room->delete()){
            return response([
                'message' => 'Delete Room Success',
                'data' => $room
            ], 200);
        }

        return response([
            'message' => 'Delete room Failed',
            'data' => null
        ], 400);
    }
}
