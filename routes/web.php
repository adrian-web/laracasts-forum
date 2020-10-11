<?php

use App\Http\Controllers\ForumController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Livewire\ShowThreads;

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

Route::get('/forum', ShowThreads::class)->name('forum');
Route::get('/forum/{channel}', ShowThreads::class);

Route::get('/forum/{channel}/{thread}', [ForumController::class, 'show']);

Route::get('/user/{user}', [UserController::class, 'show'])->name('user')->middleware('auth');
