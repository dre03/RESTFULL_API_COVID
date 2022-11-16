<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //method register untuk regstrasi
    function register(Request $request){
        //menangkap inputan
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];
        //menginsert data ke tabel user
        $user = User::create($input);
        $data = [
            'message' => 'Use is created successfully'
        ];
        //mengirim response json
        return response()->json($data, 200);
    }

    //membuat method login unutk login
    function login(Request $request){
        //menangkap inputan user
        $input = [
            'email' => $request->email,
            'password' => $request->password
        ];
        //melakukan autentikasi
        if(Auth::attempt($input)){
            //membuat token
            $token = Auth::user()->createToken('auth_token');
            $data = [
                'message' => 'Login successfully',
                'token' => $token->plainTextToken
            ];
            //menembalikan respon json dan status code nya
            return response()->json($data, 200);
        }else{
            $data = [
                'message' => 'email or Password is wrong'
            ];
            //menembalikan respon json dan status code nya
            return response()->json($data, 401);
        }
    }
}
