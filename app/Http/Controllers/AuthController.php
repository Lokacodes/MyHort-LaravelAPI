<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Guard;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class AuthController extends Controller
{
    public function index()
    {
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:60',
            'email' => 'required|unique:users',
            'password' => 'required|max:16|confirmed',
        ]);

        $validatedData['password'] = Hash::make($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(
            [
                'user' => $user,
                'access_token' => $accessToken
            ],
            201
        );
    }


    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'email or password is not recognised'], 400);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(
            [
                'user' => auth()->user(),
                'access_token' => $accessToken
            ],
            201
        );
    }

    public function logout()
    { 
        auth()->user()->token()->revoke();
        return response(['message' => 'logout success'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
