<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        Log::info($request);
        //Log::info($selected_role);
        // $request->validate([
        //     'username' => '',
        //     'password' => '',
        //     'confirm_password' => 'same:password',
        //     'first_name' => '',
        //     'last_name' => '',
        //     'initials' => '',
        //     'selected_branch' => '',
        //     'selected_role' => '',
        //     'selected_department' => '',
        //     'designation' => '',
        //     'license_number' => '',
        //     'esignature' => '',
        //     'allow_confidetial_test' => '',
        //     'enabled' => '',
        // ]);

        // $user = User::create([
        //     'username' => $request->username,
        //     'password' => Hash::make($request->password),
        //     'first_name' => $request->first_name,
        //     'last_name' => $request->last_name,
        //     'initials' => $request->initials,
        //     'role' => '1',
        //     'branch_id' => '1',
        //     'department_id' => 1,
        //     'digital_signature' => '/media/sample.png',
        //     'digital_signature_url' => '/media/sample.png',
        //     'allow_confidential_results' => '0',
        //     'enabled' => $request->enabled,
        //     'license' => $request->license_number,
        // ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'initials' => $request->initials,
            'role' => '1',
            'branch_id' => '1',
            'department_id' => 1,
            'digital_signature' => '/media/sample.png',
            'digital_signature_url' => '/media/sample.png',
            'allow_confidential_results' => '0',
            'enabled' => 1,
            'license' => '0010',
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'status' => '401',
                'message' => 'Wrong Username or Password!',
            ]);
        }

        $user = User::where('username', $request->username)->firstOrFail();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    // Get user details
    public function user(Request $request) {
        return $request->user();
    }

    // Get user role
    public function getUserRole(Request $request) {
        return response()->json(['role' => $request->user()->role]);
    }

    // User logout
    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
