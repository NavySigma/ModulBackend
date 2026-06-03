<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => 'Failed to register. Please check your input data',
                'data' => null,
                'errors' => $validator->errors(),
            ];

            return response()->json($response, 400);
        }

        $user = User::create($validator->validated());
        $response = [
            'success' => true,
            'message' => 'Successfully register.',
            'data' => $user,
        ];

        return response()->json($response, 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => 'Failed to login. Please check your input data',
                'data' => null,
                'errors' => $validator->errors(),
            ];

            return response()->json($response, 400);
        }

        $credentials = $request->only('email', 'password');
        if (! $token = auth()->attempt($credentials)) {
            $response = [
                'success' => false,
                'message' => 'Failed to login. Wrong username or password',
                'data' => null,
            ];

            return response()->json($response, 400);
        }

        $response = [
            'success' => true,
            'message' => 'Successfully login.',
            'data' => auth()->guard('api')->user(),
            'accesstoken' => $token,
        ];

        return response()->json($response, 200);
    }

    public function logout()
    {
        auth()->logout();

        $response = [
            'success' => true,
            'message' => 'Successfully logout.',
        ];

        return response()->json($response, 200);
    }
}
