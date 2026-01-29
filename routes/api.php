<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GitDeployController;

Route::post('/git-deploy', [GitDeployController::class, 'deploy']);

Route::get('/test-api', function () {
    return response()->json(['message' => 'API operativa para irisDRG']);
});