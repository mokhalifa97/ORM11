<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();

        return response()->json([
            "message" => "show all users",
            "data" => $user
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "email" => 'required|email',
            "password" => 'required|string',
            "name" => 'required|string',
        ]);

        $newUser = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            "message" => "New User Created successfully",
            "data" => $newUser
        ]);
    }

    public function show(User $user)
    {
        return response()->json([
            "message" => "Show User",
            "data" => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'email' => 'nullable|email',
            'name' => 'required|string|max:255',
        ]);
        $user->update($validatedData);

        return response()->json([
            "message" => "update User successfully",
            "data" => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
