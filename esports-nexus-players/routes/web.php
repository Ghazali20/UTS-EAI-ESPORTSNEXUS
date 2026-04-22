<?php
use App\Http\Controllers\PlayerApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });

// Management & Profile UI (JANGAN ada kata 'api' di sini agar tidak tabrakan)
Route::get('/players/manage', [PlayerApiController::class, 'manage']);
Route::post('/players/store', [PlayerApiController::class, 'store']);

// Ini adalah route yang kamu buka di browser
Route::get('/players/{id}/profile', [PlayerApiController::class, 'showProfile']);

// Action button untuk update win/loss
Route::post('/players/{id}/process-match', [PlayerApiController::class, 'processMatch']);

// Tambahkan di bagian bawah setelah route process-match
Route::delete('/players/{id}', [PlayerApiController::class, 'destroy']);