<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request)
{
    try {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        $token = $user->createToken('MyAppToken')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    } catch (ValidationException $e) {
        // Validation error occurred
        return response()->json(['error' => $e->validator->errors()->first()], 422);
    } catch (\Exception $e) {
        // Other unexpected errors
        Log::error('User registration failed: ' . $e->getMessage());
        return response()->json(['error' => 'User registration failed.'], 500);
    }
}



    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = $request->user();
        $token = $user->createToken('MyAppToken')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }
}
