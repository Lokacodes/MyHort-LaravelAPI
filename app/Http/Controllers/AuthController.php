<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Guard;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use PhpParser\Node\Stmt\Return_;
use App\Http\Resources\UserResource;

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
            'name' => 'required|max:60|min:5',
            'email' => 'required|unique:users|email',
            'password' => 'required|max:16|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
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
            return response(['message' => 'email or password is not recognised'], 401);
        }

        $user = auth()->user();
        $accessToken = $user->createToken('authToken')->accessToken;
        // $user->forceFill([
        //     'access_token' => $accessToken
        // ])->save();

        return response(
            [
                'user' => auth()->user(),
                'access_token' => $accessToken
            ],
            200
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
    public function show()
    {
        Return auth()->user();
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
    public function update(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $user->update($input);
        return response(["user" => new UserResource($user),'message'=> 'User data successfully updated'],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $user = auth()->user();
        $this->logout();
        $user->delete();
        return response(["user" => new UserResource($user),'message'=> 'User data successfully deleted'],200);
    }
}
