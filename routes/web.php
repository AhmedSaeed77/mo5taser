<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Site\Course\CourseController;
use App\Http\Controllers\Site\Payment\PaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// set site lang

Route::get('lang/{locale}', function ($locale) {session()->put('locale', $locale); return redirect()->back();});

Auth::routes();

Route::get('otp/verify', [LoginController::class, '_verify'])->middleware('auth')->name('verify_otp');
Route::post('otp/verify', [LoginController::class, 'verify'])->middleware('auth');
Route::get('otp/verify/resend', [LoginController::class, 'verifyResend'])->middleware('auth')->name('resend_verify_otp');


Route::get('reset-password', [LoginController::class, '_reset'])->name('reset_password');
Route::post('reset-password/otp', [LoginController::class, '_resetOtp'])->name('reset_password_otp');
Route::post('reset-password/otp/verified/{token}', [LoginController::class, 'resetOtpVerify'])->name('reset_password_otp_verified');
Route::post('reset-password/otp/verify/{token}', [LoginController::class, '_resetOtpVerify'])->name('reset_password_otp_verify');
Route::get('reset-password/otp/verify/{token}', [LoginController::class, 'resetOtpVerifyWithToken'])->name('reset_password_otp_verify_with_token');
Route::get('reset-password/otp/{token}', [LoginController::class, 'resetOtp'])->name('reset_password_otp_token');

Route::get('/','HomeController@welcome')->name('home')->middleware('verify_otp');
Route::get('/hadeer','HomeController@hadeer')->name('hadeer');

Route::namespace('Site')->middleware('verify_otp')->group(function () {
    Route::get('about','About\AboutController@index')->name('about');
    Route::get('news','News\NewsController@index')->name('news');
    Route::get('news/{id}','News\NewsController@show')->name('show.news');
    Route::get('contact','Contact\ContactController@index')->name('contact');
    Route::post('contact','Contact\ContactController@store')->name('site.contact.store');
    Route::get('privacy','Privacy\PrivacyController@index')->name('privacy');
    Route::get('term','Term\TermController@index')->name('term');
    Route::get('exams','Exam\ExamController@index')->name('exams');
    Route::get('assemblies','Assemble\AssembleController@index')->name('assemblies');
    Route::get('assemblies/{id}','Assemble\AssembleController@show')->name('assemblies_show');
    Route::get('buy/{assemble}/{type}','Assemble\AssembleController@buy')->name('assemblies_buy')->middleware('auth');
    Route::post('assemble-checkout','Assemble\AssembleController@checkout')->name('assemble_checkout')->middleware('auth');
    Route::get('assemble-pill/{id}','Assemble\AssembleController@pill')->name('assemble_pill')->middleware('auth');

    Route::get('store','Store\StoreController@index')->name('site_store');
    Route::get('store/{id}','Store\StoreController@show')->name('site_store_show');
    Route::get('store/buy/{store}/{type}','Store\StoreController@buy')->name('site_store_buy')->middleware('auth');
    Route::post('store-checkout','Store\StoreController@checkout')->name('site_store_checkout')->middleware('auth');
    Route::get('store-pill/{id}','Store\StoreController@pill')->name('site_store_pill')->middleware('auth');

    Route::get('exam/{id}','Exam\ExamController@enterExam')->name('enter_exam')->middleware('auth');
    Route::post('exam/submit','Exam\ExamController@SubmitExam')->name('exam_submit')->middleware('auth');
    Route::get('profile','User\UserController@profile')->name('profile')->middleware('auth');
    Route::get('notifications','User\UserController@Notifications')->name('notifications')->middleware('auth');
    Route::delete('delete/notifications','User\UserController@DeleteNotifications')->name('delete.notifications')->middleware('auth');
    Route::get('my-courses','User\UserController@MyCourses')->name('my-courses')->middleware('auth');
    Route::get('account','User\UserController@account')->name('account')->middleware('auth');
    Route::get('certificate/{id}','User\UserController@Certificate')->name('certificate')->middleware('auth');
    Route::put('user_update/{id}','User\UserController@update')->name('user.update')->middleware('auth');
    Route::get('attempts/{slug}','Attempt\AttemptController@index')->name('attempts')->middleware('auth');
    Route::get('attempts/details/{id}','Attempt\AttemptController@show')->name('attempts.details')->middleware('auth');
    Route::get('attempts/result/{id}','Attempt\AttemptController@attemptResult')->name('attempts.result')->middleware('auth');
    Route::get('course/{id}','Course\CourseController@show')->name('course.show');
    Route::get('courses','Course\CourseController@index')->name('courses');
    Route::get('single-course/{id}','Course\SingleCourseController@show')->name('single-course')->middleware('auth');
    Route::get('course-units/{id}','Course\SingleCourseController@CourseUnits')->name('site.course-units')->middleware('auth');
    Route::post('get-content','Course\SingleCourseController@getContent')->name('get-content');
    Route::post('content-comment','Course\ContentCommentController@store')->name('content-comment');
    Route::post('content-comment-reply','Course\ContentCommentController@commentReply')->name('content-comment-reply');
    Route::post('course-progress','Course\SingleCourseController@CourseProgress')->name('course-progress');
    Route::get('course-exam/{id}','Course\ExamController@enterExam')->name('course-exam')->middleware('auth');
    Route::post('course-exam/submit','Course\ExamController@SubmitExam')->name('course-exam.submit')->middleware('auth');
    Route::get('single/result/{id}','Course\ExamController@attemptResult')->name('single.result')->middleware('auth');
    Route::get('course-pdf/{id}','Course\SingleCourseController@CoursePdf')->name('course-pdf')->middleware('auth');

    Route::get('exam-attempts-site/{id}','Course\ExamController@getExamattempts')->name('exam-attempts-site')->middleware('auth');
    Route::get('details-attempts-site/{id}/{attempt_number}','Course\ExamController@examDetailsattempts')->name('details-attempts-site')->middleware('auth');

    Route::post('rating','Rating\RatingController@store')->name('course.rating')->middleware('auth');
    Route::post('addToCart', 'Course\CartController@addToCart')->name('addToCart')->middleware('auth');
    Route::get('buy-course/{id}', 'Course\CartController@BuyCourse')->name('buy-course')->middleware(['auth']);
    Route::get('/removeFromCart/{course}', 'Course\CartController@destroy')->name('removeFromCart')->middleware('auth');
    Route::get('checkout', 'Course\CartController@getCartItems')->name('checkout')->middleware('auth');
    Route::get('delete/cart', 'Course\CartController@deleteCart')->name('delete.cart')->middleware('auth');
    Route::get('search', 'Search\SearchController@search')->name('search');
    Route::get('contest/{id}','Contest\ContestController@show')->name('contest');
    Route::post('course-subscribe-ajax','Subscribe\SubscribeController@CourseSubscribe')->name('course_subscribe');
    Route::resource('payment','Payment\PaymentController')->only(['index','store']);
    Route::post('payment/electronic', [PaymentController::class, 'electronic'])->name('electronic_pay')->middleware('auth');
    Route::get('payment/electronic/callback', [PaymentController::class, 'electronicCallback'])->name('electronic_payment_callback')->middleware('auth');
    Route::any('payment/electronic/webhook', [PaymentController::class, 'webhook'])->name('electronic_payment_webhook');
    Route::get('bag/{id}','Course\CourseController@showContent')->name('bag_show');
    Route::get('table/{id}','Course\CourseController@showTable')->name('table_show');
    Route::resource('join-teacher','Join\JoinController')->only(['index','store']);
    Route::post('exchange-request','Exchange\ExchangeController@store')->name('exchange-request');
    Route::get('subscribe-free-course/{id}', [CourseController::class, 'subscribeFreeCourse'])->name('subscribe_free_course')->middleware('auth');
});
