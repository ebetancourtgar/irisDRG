<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GitDeployController;

Route::post('/git-deploy', [GitDeployController::class, 'deploy']);

// Other API routes can be defined here