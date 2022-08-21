<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BlogsController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FeedbackController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/blogs', [BlogsController::class, 'blogsResponse']);
Route::get('blog/{id}', [BlogsController::class, 'blogResponse']);

Route::post('/newsletter', [NewsLetterController::class, 'addEmailResponse']);
Route::post('/contact', [ContactController::class, 'postContactResponse']);
Route::post('/feedback', [FeedbackController::class, 'postFeedBackResponse']);

Route::post('/client/register', [ClientsController::class, 'clientRegisterResponse']);
Route::post('/client/register/confirm', [ClientsController::class, 'clientRegisterConfirmResponse']);
Route::post('/client/register/confirm/cancel', [ClientsController::class, 'removeRegistrationConfirmationCode']);
Route::post('/client/getin', [ClientsController::class, 'getInResponse']);
Route::post('/client/profile', [ClientsController::class, 'profileResponse'])->middleware('clientLoggedResponse');
Route::post('/client/get-out', [ClientsController::class, 'getOutResponse'])->middleware('clientLoggedResponse');
Route::post('/client/edit-info', [ClientsController::class, 'editInfoResponse'])->middleware('clientLoggedResponse');
Route::post('/client/edit-info/picture', [ClientsController::class, 'updateProfilePictureResponse'])->middleware('clientLoggedResponse');
Route::post('/client/edit-info/password', [ClientsController::class, 'updatePasswordResponse'])->middleware('clientLoggedResponse');
Route::post('/client/forgot-password/email', [ClientsController::class, 'forgotPasswordEmailResponse']);
Route::post('/client/forgot-password/code', [ClientsController::class, 'forgotPasswordCodeResponse']);


Route::post('/test', [ClientsController::class, 'test'])->middleware('clientLoggedResponse');