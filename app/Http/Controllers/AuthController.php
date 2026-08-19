<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Identifiants incorrects.'], 401);
        }

        $code = rand(100000, 999999);
        $user->two_factor_code = $code;
        $user->two_factor_expires_at = now()->addMinutes(10); // Expire dans 10 minutes
        $user->save();

        return response()->json([
            'message' => 'Un code de vérification 2FA a été généré.',
            'two_factor_required' => true,
            'debug_code' => $code // À retirer en production
        ]);
    }

    public function verify2FA(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|numeric',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->two_factor_code !== (string)$request->code) {
            return response()->json(['message' => 'Code 2FA invalide.'], 401);
        }

        if ($user->two_factor_expires_at && now()->greaterThan($user->two_factor_expires_at)) {
            return response()->json(['message' => 'Le code 2FA a expiré.'], 401);
        }

        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie.',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'client_type' => $user->client_type,
                'credit_limit' => $user->credit_limit,
                'current_encours' => $user->current_encours,
                'has_unpaid_bills' => $user->has_unpaid_bills,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnexion réussie.']);
    }
}