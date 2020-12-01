<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();

        if(count($user) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $user
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
            'name'               => 'required|max:60',
            'username'           => 'required|max:60',
            'phone_number'       => 'required|max:60',
            'email'              => 'required|email|unique:users',
            'password'           => 'required|confirmed',


     
        ]);

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400);
        }
        
        $storeData = new User;
        $storeData->name = $request->input('name');
        $storeData->username = $request->input('username');
        $storeData->phone_number = $request->input('phone_number');
        $storeData->email = $request->input('email');
        $storeData->password = Hash::make($request->input('password'));
        $storeData->save();

        return response([
            'message'   => 'Add User Success',
            'data'      => $storeData
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
        $user = User::find($id);

        if(!is_null($user)){
            return response([
                'message' => 'Retrieve User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'User Not Found',
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
        $user = User::find($id);
        if(is_null($user)){
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name'               => 'required|max:60',
            'username'           => 'required|max:60',
            'phone_number'       => 'required|max:60',
            'email'              => ['required', 'email', Rule::unique('users')->ignore($user)],
            'password'           => 'required|confirmed',
        ]);

        if($validate->fails()){
            return response(['message' => $validate-errors()], 400);
        }

        $user->name             = $updateData['name'];
        $user->username        = $updateData['username'];
        $user->phone_number     = $updateData['phone_number'];
        $user->email            = $updateData['email'];

        if($user->save()){
            return response([
                'message' => 'Update User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update User Failed',
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
        $user = User::find($id);

        if(is_null($user)){
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }

        if($user->delete()){
            return response([
                'message' => 'Delete User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Delete User Failed',
            'data' => null
        ], 400);
    }

    public function register(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'name'               => 'required|max:60',
            'username'           => 'required|max:60',
            'phone_number'       => 'required|max:60',
            'email'              => 'required|email|unique:users',
            'password'           => 'required|confirmed',
        ]);

        if($validate->fails()){
            return response(['message' => [$validate->errors()]], 400);
        }

        $storeData = new User;
        $storeData->name = $request->input('name');
        $storeData->username = $request->input('username');
        $storeData->phone_number = $request->input('phone_number');
        $storeData->email = $request->input('email');
        $storeData->password = Hash::make($request->input('password'));
        $storeData->save();
        $storeData->sendEmailVerificationNotification();

        $findUsers = DB::table('users')
            ->where('email', $request->email)
            ->get();

        if(count($findUsers) > 0){
            foreach($findUsers as $findUser){

                //Memanggil Session Login
                $result["id"]           = $findUser->id;
                $result["name"]    = $findUser->name;
                $result["email"]        = $findUser->email; 
            }

            return response([
                'status'    => 'success',
                'message'   => 'Registration Succesfully, Please Confirm Your Email Address',
                'data'      => $result
            ], 200);
        }
        else{
            return response([
                'status'    => 'failed',
                'message'   => 'Registration Failed'
            ], 400);
        }
    }

    public function resend($id) {
        
        $user = User::findOrFail($id);

        if ($user->hasVerifiedEmail()) {
                return response([
                    'status'   => 'already verified',
                    'message'   => 'User already have verified email!',
                ], 200);

        }

        $user->sendEmailVerificationNotification();

        return response([
            'status'   => 'success',
            'message'   => 'Email verification link sent on your email id',
        ], 404);

    }
}
