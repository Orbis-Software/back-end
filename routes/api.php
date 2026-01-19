<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::middleware('throttle:login')->post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']); // if you want it
    });
});


/*
|--------------------------------------------------------------------------
| Protected Application Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {



});


Route::get('/_migrate', function () {
    $token = request()->query('token');

    if (!$token || $token !== 'orbis_migrate_2026_01_14') {
        abort(403, 'Forbidden');
    }

    try {
        Artisan::call('migrate', ['--force' => true, '--verbose' => true]);
        Artisan::call('db:seed', ['--force' => true, '--verbose' => true]);

        return response()->json([
            'ok' => true,
            'output' => Artisan::output(),
        ]);
    } catch (\Throwable $e) {
        Log::error('MIGRATE_FAILED', ['message' => $e->getMessage()]);
        return response()->json([
            'ok' => false,
            'message' => $e->getMessage(),
            'output' => Artisan::output(),
        ], 500);
    }
});
