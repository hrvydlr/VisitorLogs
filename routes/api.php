<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\VisitorApiController;

Route::get('/visitors', [VisitorApiController::class, 'index']);
Route::get('/visitors/{id}', [VisitorApiController::class, 'show']);
Route::post('/visitors', [VisitorApiController::class, 'store']);