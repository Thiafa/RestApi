<?php

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('/todo', TodoController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
