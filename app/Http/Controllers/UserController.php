<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        
        $large=$user->filter(fn ($user) => $user->id > 4); // thats called chaining

        return response()->json([
            "message" => "show all users",
            "data" => new UserResource($large)
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
            "data" => new UserResource($user)
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

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            "message" => "User Deleted successfully"
        ]);
    }
}
