<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PostResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all (), [
            'name'          => 'required',
            'email'         => 'required|email',
            'password'      => 'required',
            'c_password'    => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success = [
            'token' => $user->createToken('MyApp')->plainTextToken,
            'name'  => $user->name,
        ];

        return new PostResource(true, 'Register has been successfully', $success);
    }

    public function login(Request $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success = [
                'token' => $user->createToken('MyApp')->plainTextToken,
                'name'  => $user->name,
            ];

            return new PostResource(true, 'Login has been successfully', $success);
        } else {
            return new PostResource(false, 'Login has been failed');
        }
    }
}
