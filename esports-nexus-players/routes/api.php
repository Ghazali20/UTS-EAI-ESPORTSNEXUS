<?php
use App\Http\Controllers\PlayerApiController;
use Illuminate\Support\Facades\Route;

// Endpoint ini akan beralamat: http://127.0.0.1:8000/api/players/{id}
// Hanya ini yang ditaruh di sini agar bisa dikonsumsi Service B
Route::get('/players/{id}', [PlayerApiController::class, 'getPlayer']);