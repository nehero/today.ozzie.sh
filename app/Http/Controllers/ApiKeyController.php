<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ApiKeyController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
        $user = User::whereEmail($data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => [
                    'Invalid credentials',
                ]
            ]);
        }
        $token = $user->createToken('cli');
        return response()->json([
            'token' => $token->plainTextToken,
            'user' => $user,
        ]);
    }
}
