<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class LoginController extends Controller
{
    function login(Request $request){
        $logins = User::where('email', '=', $request->email)->first();

        if(Hash::check($request->password, $logins->password)){

            $loginsVerif = User::where([
                ['email', '=', $request->email],
                ['email_verified_at', '<>', null],
            ])->first();

            if($loginsVerif){
               
                //Memanggil Session Login
                $result["id"]           = $loginsVerif->id;
                $result["name"]    = $loginsVerif->name;
                $result["email"]        = $loginsVerif->email; 
                
    
                return response([
                    'status'    => 'success',
                    'message' => 'Login Success',
                    'data' => $result
                ], 200);
            }
            else{

                //Memanggil Session Login
                $result["id"]           = $logins->id;
                $result["name"]    = $logins->name;
                $result["email"]        = $logins->email; 

                return response([
                    'status'    => 'verify',
                    'message'   => 'Please Verify Your Email Address',
                    'data' => $result
                ], 404);
            }
        }
        else{
            return response([
                'message' => 'Login Unsuccessful',
                'status' => 'unauth'
            ], 404);
        }
    }

    function refresh(Request $request){
        $logins = User::where('email', '=', $request->email)->first();

        $loginsVerif = User::where([
            ['email', '=', $request->email],
            ['email_verified_at', '<>', null],
        ])->first();

        if($loginsVerif){
            
            //Memanggil Session Login
            $result["id"]           = $loginsVerif->id;
            $result["name"]    = $loginsVerif->name;
            $result["email"]        = $loginsVerif->email; 


            return response([
                'status'   => 'success',
                'message' => 'Verify Success',
                'data' => $result
            ], 200);
        }
        else{
            return response([
                'status'    => 'verify',
                'message'   => 'Please Verify Your Email Address',
                'data' => null
            ], 404);
        }
    }
}
