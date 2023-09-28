<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return response()->json([
                "response" => "successful",
                "message" => "Authenticated",
                "data" => Auth::user(),
            ]);
        }
        else
        {
            return $this->responseNotFound();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            "name" => ['required'],
            "last_name" => ['required'],
        ]);

        $newUser = User::create($validated);

        return $newUser; 
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            "name" => ['required'],
            "last_name" => ['required'],
            'password' => ['required'],
        ]);

        $user = User::find($id);

        $user->name = $validated["name"];
        $user->last_name = $validated["last_name"];
        $user->password = $validated["password"];

        $user->save();

        return response()->json([
            "data" => $user,
            "message" => "User modified",
            "response" => "successful"
        ]);
    }

    public function index()
    {
        return response()->json([
            "response" => "successful",
            "data" => User::all(),
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!isset($user))
        {
            return $this->responseNotFound();
        }

        return response()->json([
            "response" => "successful",
            "data" => $user,
        ]);
    }

    public function drop($id)
    {
        $user = User::find($id);

        if (!isset($user))
        {
            return $this->responseNotFound();
        }

        $user->delete($id);

        return response()->json([
            "response" => "successful",
            "message" => "User was deleted",
        ]);
    }

    private function responseNotFound()
    {
        return response()->json([
            "response" => "unsuccessful",
            "message" => "User Not Found",    
        ]);
    }
}
