<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GitDeployController;

Route::post('/git-deploy', [GitDeployController::class, 'deploy']);