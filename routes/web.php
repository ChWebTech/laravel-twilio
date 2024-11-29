<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwilioTokenController;
use App\Http\Controllers\TwilioCallController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/twilio-token', [TwilioTokenController::class, 'generateToken']);
Route::get('/', [App\Http\Controllers\TwilioCallController::class, 'index']);
Route::post('/twilio-outgoing-call', [TwilioCallController::class, 'outgoingCall']);
