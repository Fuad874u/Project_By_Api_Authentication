<?php

namespace App\Http\Controllers\API\V1;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Psr\Http\Message\ResponseInterface;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validated();
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => 'Vaidation Errors',
                    'status' => 422
                ], 422);
            }
            $request->validated();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            $token = $user->createToken('ABC_123')->plainTextToken;
            return response()->json([
                'user' => $user,
                'message' => 'Post Created Successfully',
                'status' => 201,
                'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            Log::error('User registration failed', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        };
    }
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Vaidation Errors',
                'status' => 422
            ], 422);
        }

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'unauthorized',
                'status' => 401,
            ], 401);
        };

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('ABC_123')->plainTextToken;
        return response()->json([
            'user' => $user,
            'message' => 'User Loggedin Successfully',
            'status' => 201,
            'token' => $token,
        ], 201);
    }
    public function logout(Request $request)
    {

        Auth::user()->currentAccessToken()->delete();
        //delete all tokens for all devices 
        //Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'user logged out successfully',
            'status' => 200,
        ], 200);
    }
    public function getData()
    {

        $data = User::all();
        return response()->json([
            'Data' => $data,
            'message' => 'data showed successfully',
            'status' => 200
        ], 200);
    }
}
