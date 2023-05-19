<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('user/register', [UserController::class, 'register']);
Route::get('user/verify', [UserController::class, 'verifyEmail'])->name('mail.verify');
Route::view('/hi', 'emails.aaa');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
