<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ApiAuthController extends Controller
{
    public function token(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['required', 'string', 'max:100'],
        ]);

        $user = \App\Models\User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The supplied credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($data['device_name'], ['api:read', 'api:write'])->plainTextToken;

        return response()->json([
            'success' => true,
            'token_type' => 'Bearer',
            'access_token' => $token,
            'expires_at' => null,
            'message' => 'Store this token securely and send it as Authorization: Bearer <token>.',
        ]);
    }

    public function revoke(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['success' => true, 'message' => 'API token revoked.']);
    }
}
