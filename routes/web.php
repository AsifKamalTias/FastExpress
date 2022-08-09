<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\DeliveryMansController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\DeliveriesController;
use App\Http\Controllers\NewsLetterController;


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
Route::get('/how-it-works', [PagesController::class, 'viewHowItWorks'])->name('how-it-works');
Route::get('/terms-and-conditions', [PagesController::class, 'viewTermsAndConditions'])->name('terms-and-conditions');
Route::get('/faq', [PagesController::class, 'viewFaq'])->name('faq');

Route::get('/subscribe', [NewsLetterController::class, 'viewNotFound']);
Route::post('/subscribe', [NewsLetterController::class, 'addEmail'])->name('subscribe');

Route::get('/contact', [ContactController::class, 'viewContact'])->name('contact');
Route::post('/contact', [ContactController::class, 'postContact'])->name('contact.post');

Route::get('/feedback', [FeedbackController::class, 'viewFeedback'])->name('feedback');
Route::post('/feedback', [FeedbackController::class, 'postFeedback'])->name('feedback.post');

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

Route::get('/profile', [ClientsController::class, 'viewProfile'])->name('client.profile')->middleware('clientAuth');
Route::get('/profile/edit', [ClientsController::class, 'viewProfileEdit'])->name('client.profile.edit')->middleware('clientAuth');
Route::post('/profile/edit', [ClientsController::class, 'profileEditApply'])->name('client.profile.edit.apply')->middleware('clientAuth');
Route::get('/profile/edit/picture', [ClientsController::class, 'viewProfileEditPicture'])->name('client.profile.edit.picture')->middleware('clientAuth');
Route::post('/profile/edit/picture', [ClientsController::class, 'viewProfileEditPictureApply'])->name('client.profile.edit.picture.apply')->middleware('clientAuth');
Route::get('/profile/edit/password', [ClientsController::class, 'viewProfileEditPassword'])->name('client.profile.edit.password')->middleware('clientAuth');
Route::post('/profile/edit/password', [ClientsController::class, 'profileEditPassword'])->name('client.profile.edit.password.apply')->middleware('clientAuth');

Route::get('/delivery/from', [DeliveriesController::class, 'viewDeliveryFrom'])->name('delivery.from')->middleware('clientAuth');
Route::post('/delivery/from', [DeliveriesController::class, 'deliveryFromStore'])->name('delivery.from.store')->middleware('clientAuth');
Route::get('/delivery/to', [DeliveriesController::class, 'viewDeliveryTo'])->name('delivery.to')->middleware('clientAuth', 'deliveryTo');
Route::post('/delivery/to', [DeliveriesController::class, 'deliveryToStore'])->name('delivery.to.store')->middleware('clientAuth', 'deliveryTo');
Route::get('/delivery/confirm', [DeliveriesController::class, 'viewDeliveryConfirm'])->name('delivery.confirm')->middleware('clientAuth', 'deliveryTo', 'deliveryConfirm');
Route::post('/delivery/confirm', [DeliveriesController::class, 'deliveryConfirmApply'])->name('delivery.confirm.apply')->middleware('clientAuth', 'deliveryTo', 'deliveryConfirm');
Route::get('/profile/deliveries', [DeliveriesController::class, 'showOrderedDeliveries'])->name('profile.deliveries')->middleware('clientAuth');


Route::get('/destroy', [ClientsController::class, 'clearSessions'])->name('delete.sessions');
//Route::get('/test', [ClientsController::class, 'test'])->name('test');

Route::get('/blogs', [BlogsController::class, 'viewBlogs'])->name('blogs');
Route::get('/blog/{id}', [BlogsController::class, 'viewBlog'])->name('blog');





// deliveryMan
Route::get('/deliveryman/register', [DeliveryMansController::class, 'viewRegister'])->name('deliveryman.register')->middleware('deliverymanLogged');
Route::post('/deliveryman/register', [DeliveryMansController::class, 'dmRegister'])->name('deliveryman.register');
// Route::get('/deliveryman/register/confirm', [DeliveryMansController::class, 'dmRegisterConfirm'])->name('deliveryman.register.confirm');
Route::get('/deliveryman/dashboard', [DeliveryMansController::class, 'dmLoginSuccess'])->name('deliveryman.dashboard')->middleware('deliverymanAuth');
Route::get('/deliveryman/login', [DeliveryMansController::class, 'DmLoginView'])->name('deliveryman.login')->middleware('deliverymanLogged');
Route::post('/deliveryman/login', [DeliveryMansController::class, 'DmLogin'])->name('deliveryman.login');
Route::get('/deliveryman/logout', [DeliveryMansController::class, 'DmLogout'])->name('deliveryman.logout')->middleware('deliverymanAuth');
Route::get('/deliveryman/changepassword', [DeliveryMansController::class, 'ViewChangePassword'])->name('deliveryman.changepassword');
Route::post('/deliveryman/changepassword', [DeliveryMansController::class, 'ChangePassword'])->name('deliveryman.changepassword');
Route::get('/deliveryman/password/changed', [DeliveryMansController::class, 'ViewPasswordChanged'])->name('deliveryman.password.changed');

Route::get('/deliveryman/forgot/password', [DeliveryMansController::class, 'ViewForgotPass'])->name('deliveryman.forgotpass');
Route::post('/deliveryman/forgot/password', [DeliveryMansController::class, 'ForgotPass'])->name('deliveryman.forgotpass');

Route::get('/deliveryman/get/deliveries', [DeliveryMansController::class, 'GetDeliveries'])->name('deliveryman.gtDeliveries')->middleware('deliverymanAuth');
Route::get('/deliveryman/get/deliveries/accept/{id}', [DeliveryMansController::class, 'AcceptDeliveries'])->name('deliveryman.gtDeliveries.accept')->middleware('deliverymanAuth');

Route::get('/deliveryman/mydeliveries', [DeliveryMansController::class, 'MyDeliveries'])->name('deliveryman.myDeliveries')->middleware('deliverymanAuth');
Route::get('/deliveryman/mydeliveries/complete/{id}', [DeliveryMansController::class, 'CompleteDeliveries'])->name('deliveryman.completeDeleveries')->middleware('deliverymanAuth');

Route::get('/deliveryman/deliveries/completed', [DeliveryMansController::class, 'DeliveriesCompleted'])->name('deliveryman.deliveriesCompleted')->middleware('deliverymanAuth');

Route::get('/deliveryman/profile/edit', [DeliveryMansController::class, 'EditProfile'])->name('deliveryman.editProfile')->middleware('deliverymanAuth');
Route::post('/deliveryman/profile/edit', [DeliveryMansController::class, 'EditProfileConfirm'])->name('deliveryman.editProfile')->middleware('deliverymanAuth');











