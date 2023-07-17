<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' =>'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        //jika validasi gagal 
        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create user 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //kembalikan data user ketika berhasil mendaftar
        if($user) {
            return response()->json([
                'success' => true,
                'user' => $user
            ], 201);
        }

        //jika gagal
        return response()->json([
            'success' => false,
        ], 409);
    }
}
