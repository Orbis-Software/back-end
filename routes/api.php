<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactPersonController;
use App\Http\Controllers\TransportJobController;

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

    // Route::apiResource('companies', CompanyController::class);
    Route::get('/company', [CompanyController::class, 'show']);
    Route::post('/company', [CompanyController::class, 'update']);
    Route::patch('/company', [CompanyController::class, 'update']);
    Route::apiResource('contacts', ContactController::class);
    Route::apiResource('contact-people', ContactPersonController::class);
    Route::apiResource('transport-jobs', TransportJobController::class);

});


Route::get('/_migrate', function () {
    $token = request()->query('token');

    if (!$token || $token !== 'orbis_migrate_2026_01_14') {
        abort(403, 'Forbidden');
    }

    try {
        // ✅ Ensure storage symlink exists
        Artisan::call('storage:link');
        $storageOutput = Artisan::output();

        // ✅ Run migrations
        Artisan::call('migrate', [
            '--force' => true,
            '--verbose' => true,
        ]);
        $migrateOutput = Artisan::output();

        Artisan::call('db:seed', [
            '--force' => true,
            '--verbose' => true,
        ]);
        $seedOutput = Artisan::output();

        return response()->json([
            'ok' => true,
            'storage_link' => $storageOutput,
            'migrate' => $migrateOutput,
            'seed' => $seedOutput,
        ]);
    } catch (\Throwable $e) {
        Log::error('MIGRATE_FAILED', [
            'message' => $e->getMessage(),
        ]);

        return response()->json([
            'ok' => false,
            'message' => $e->getMessage(),
            'output' => Artisan::output(),
        ], 500);
    }
});
