<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\DeliveryMansController;
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
Route::get('/about', [PagesController::class, 'viewAbout'])->name('about');
Route::get('/contact', [PagesController::class, 'viewContact'])->name('contact');
Route::get('/feedback', [PagesController::class, 'viewFeedBack'])->name('feedback');
Route::get('/how-it-works', [PagesController::class, 'viewHowItWorks'])->name('how-it-works');
Route::get('/terms-and-conditions', [PagesController::class, 'viewTermsAndConditions'])->name('terms-and-conditions');



Route::get('/get-in', [ClientsController::class, 'viewGetIn'])->name('get-in')->middleware('clientLogged');
Route::post('/get-in', [ClientsController::class, 'clientGetIn'])->name('client.get-in');
Route::get('/get-in/forgot', [ClientsController::class, 'viewForgotPassword'])->name('get-in.forgot')->middleware('clientLogged');
Route::post('/get-in/forgot', [ClientsController::class, 'clientForgotPassword'])->name('get-in.forgot.client');
Route::get('/get-in/forgot/confirm', [ClientsController::class, 'viewClientForgotPasswordConfirm'])->name('get-in.forgot.client.confirm')->middleware('forgotPasswordQueue');
Route::post('/get-in/forgot/confirm', [ClientsController::class, 'clientForgotPasswordConfirmApply'])->name('get-in.forgot.client.confirm.apply');
Route::get('/get-out', [ClientsController::class, 'clientGetOut'])->name('client.get-out')->middleware('clientAuth');

Route::get('/register', [ClientsController::class, 'viewRegister'])->name('register')->middleware('clientLogged', 'registrationQueue');//done
Route::post('/register', [ClientsController::class, 'clientRegister'])->name('client.register');//done
Route::get('/register/confirm', [ClientsController::class, 'viewClientRegisterConfirm'])->name('client.register.confirm')->middleware('registrationQueueDenied');//done
Route::post('/register/confirm/apply', [ClientsController::class, 'clientRegisterConfirm'])->name('client.register.confirm.apply');//done
Route::get('/register/confirm/apply', [ClientsController::class, 'clientRegisterConfirmApply'])->name('client.register.confirm.apply.view');//done
Route::get('/register/confirm/cancel', [ClientsController::class, 'clientRegisterConfirmCancel'])->name('client.register.confirm.cancel')->middleware('registrationQueueDenied');//done 

Route::get('/profile', [ClientsController::class, 'viewProfile'])->name('client.profile');



Route::get('/destroy', [ClientsController::class, 'clearSessions'])->name('delete.sessions');
Route::get('/test', [ClientsController::class, 'test'])->name('test');
Route::get('/blogs', [BlogsController::class, 'viewBlogs'])->name('blogs');





// deliveryMan
Route::get('/deliveryman/register', [DeliveryMansController::class, 'viewRegister'])->name('deliveryman.register');
Route::post('/deliveryman/register', [DeliveryMansController::class, 'dmRegister'])->name('deliveryman.register');
Route::get('/deliveryman/register/confirm', [DeliveryMansController::class, 'dmRegisterConfirm'])->name('deliveryman.register.confirm');
Route::get('/deliveryman/dashboard', [DeliveryMansController::class, 'dmLoginSuccess'])->name('deliveryman.login.success');









