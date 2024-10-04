<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Driver;
use App\Models\Customer;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        try {
            
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
                'role' => 'required|string|exists:roles,name'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            if ($data['role'] === 'admin') {
                return response()->json([
                    'message' => 'error',
                    'error'=> 'You are not allowed to register as an admin'
                ], 403);
            }
        
        } catch (\Exception $e) {
            Log::error('ERROR REGISTERING USERS');
            Log::error($e);
            
            return response()->json([
                'message' => 'An error occurred while registering users',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string'
            ]);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $user = User::where('email', $credentials['email'])->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;

            Log::info('USER LOGGED IN PERMISSIONS');
            Log::info($user->getAllPermissions());

            return response()->json([
                'access_token' => $token,
            ], 200);


        } catch (Exception $e) {
            Log::error('ERROR LOGGING IN USERS');
            Log::error($e);
            return response()->json([
                'message' => 'An error occurred while logging in user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logged out successfully'
            ], 200);

        } catch (Exception $e) {
            Log::error('ERROR LOGGING OUT USERS');
            Log::error($e);
            return response()->json([
                'message' => 'An error occurred while logging out user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}