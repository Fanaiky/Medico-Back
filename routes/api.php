<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/verify-2fa', [AuthController::class, 'verify2FA']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/clients', [ClientController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/me', function (\Illuminate\Http\Request $request) {
        $user = $request->user();
        
        $isBlocked = $user->has_unpaid_bills || ($user->current_encours > $user->credit_limit);
        
        return response()->json([
            'user' => $user,
            'is_blocked' => $isBlocked,
            'block_reason' => $isBlocked 
                ? 'Commande impossible : Votre compte présente un encours ou des factures impayées dépassant votre limite autorisée.' 
                : null
        ]);
    });
});