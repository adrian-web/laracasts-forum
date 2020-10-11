<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get('/forum', [ThreadController::class, 'index'])->name('forum');
Route::get('/forum/{channel}', [ThreadController::class, 'index']);
Route::get('/forum/{channel}/{thread}', [ThreadController::class, 'show']);

Route::get('/user/{user}', [ProfileController::class, 'show'])->name('user')->middleware('auth');
