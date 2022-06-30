<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\BlogsController;

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

Route::get('/', [PagesController::class, 'viewHome'])->name('home');
Route::get('/blogs', [BlogsController::class, 'viewBlogs'])->name('blogs');
Route::get('/get-in', [ClientsController::class, 'viewGetIn'])->name('get-in');
Route::get('/register', [ClientsController::class, 'viewRegister'])->name('register')->middleware('clientLogged', 'registrationQueue');
Route::post('/register', [ClientsController::class, 'clientRegister'])->name('client.register');
Route::get('/register/confirm', [ClientsController::class, 'viewClientRegisterConfirm'])->name('client.register.confirm');
//Route::post('/register/confirm', [ClientsController::class, 'clientRegisterConfirm'])->name('client.register.confirm.post');
Route::post('/register/add', [ClientsController::class, 'clientRegisterConfirm'])->name('client.register.confirm.post');
Route::get('/profile', [ClientsController::class, 'viewProfile'])->name('client.profile');
Route::get('/get-out', [ClientsController::class, 'clientGetOut'])->name('client.get-out');

Route::get('/destroy', [ClientsController::class, 'clearSessions'])->name('delete.sessions');
Route::get('/test', [ClientsController::class, 'test'])->name('test');













