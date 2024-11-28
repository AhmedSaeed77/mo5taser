<?php

namespace App\Http\Controllers\User\ClinicControl\Clinic;

use App\Http\Controllers\Api\DevelopmentalSetting\DevelopmentalSettingController;
use App\Http\Controllers\Api\Payment\PaymentController;
use App\Http\Controllers\Api\Users\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Api' , ['middleware' => 'Localization']], function() {

    Route::post('register', 'Users\UserController@register');                                               // register
    Route::post('login', 'Users\UserController@authenticate');                                              // login.
    Route::post('phone-login', 'Users\UserController@LoginWithPhone');
    Route::get('send-verify-otp', [UserController::class, 'sendVerifyOtp'])->middleware('jwt.verify');
    Route::post('verify-otp', [UserController::class, 'verifyOtp'])->middleware('jwt.verify');
    Route::post('reset-password', [UserController::class, 'resetPassword']);
    Route::post('reset-password/verify-code', [UserController::class, 'verifyResetToken']);
    Route::post('reset-password/verified-code', [UserController::class, 'verifiedResetToken']);

    Route::post('change-lang', 'Lang\LangController@index');                                            // change app lang
    Route::get('about','About\AboutController@index');                                                  // get about
    Route::get('image-control','Image\ImageController@index');                                                  // get images
    Route::get('team','Team\TeamController@index');                                                     // get team
    Route::get('news','News\NewsController@index');                                                     // get news
    Route::get('news/{id}','News\NewsController@show');                                                 // single news
    Route::get('privacy','Privacy\PrivacyController@index');                                            // get Privacy
    Route::get('terms','Term\TermController@index');                                                    // get terms
    Route::get('all-courses','Course\CourseController@index');                                          // all-courses
    Route::get('category-courses/{id}','Course\CourseController@CategoryCourses');                      // category-courses

    Route::get('course-show/{id}','Course\CourseController@show');                                     // course show

    Route::get('courses-categories/{type}','Course\CourseController@CourseCats');                       // courses - cats
    Route::post('search', 'Search\SearchController@search');
    Route::apiResource('contest', 'Contest\ContestController')->only(['index','show']);
    Route::apiResource('exam', 'Exam\ExamController')->only(['index','show']);
    Route::apiResource('assembles', 'Assemble\AssembleController')->only(['index','show']);
    Route::get('category-childs/{id}', 'Category\CategoryController@show');
    Route::get('banks', 'Bank\BankController@index');

    Route::post('change-password', 'Account\AccountController@changePassword');
    Route::post('create-new-password', 'Account\AccountController@createNewPassword');


    Route::group(['middleware' => ['jwt.verify']], function() {

        Route::get('units-api/{id}', 'Course\CourseContentController@CourseUnits');
        Route::get('course-content/{id}','Course\CourseContentController@unitContent');                          // course - content
        Route::get('course-attachement/{id}','Course\CourseController@CourseAttachment');                   // course - attachement

        Route::post('api-content-comment','Course\ContentCommentController@store');
        Route::post('api-content-comment-reply','Course\ContentCommentController@commentReply');


        Route::post('refresh', 'Users\UserController@refresh');
        Route::get('logout', 'Users\UserController@logOut');                                                // user logout

        Route::get('user', 'Users\UserController@getAuthenticatedUser');                                    // get authenticated user
        Route::get('logout', 'Users\UserController@logOut');                                                // user logout
        Route::post('user/verify', 'Users\UserController@UserVerify');                                      // user verify
        Route::put('user-update', 'Users\UserController@UpdateProfile');                                    // user UpdateProfile
        Route::put('user-update-password', 'Users\UserController@UpdatePassword');                          // user UpdatePassword
        Route::get('user-certificates', 'Users\UserController@UserCertificate');                            // user certificates

        Route::post('account-delete', 'Account\AccountController@accountDelete');


        Route::get('get-affiliate', 'Affiliate\AffiliateController@index');


        Route::get('single-course/{id}','Course\SingleCourseController@CourseContent');                      // course - content
        Route::post('add-to-progress/{id}','Course\SingleCourseController@addToProgress');                   // add to progress
        Route::post('subscribed-courses','Course\CourseController@SubscribedCourses');                       // subscribed-courses
        Route::post('rate-course/{id}','Course\CourseController@CourseRate');                                // course rate
        Route::put('update-rate-course/{id}','Course\CourseController@UpdateCourseRate');                   // Update Course Rate

        Route::get('api-course-exam/{id}','Course\ExamController@enterExam');
        Route::post('api-course-exam/submit','Course\ExamController@SubmitExam');
        Route::get('exam-attempts-api/{id}','Course\ExamController@getExamattempts');
        Route::get('details-attempts-course/{id}/{attempt_number}','Course\ExamController@examDetailsattempts');

        Route::get('course-single-result/{id}','Course\ExamController@attemptResult');
        Route::get('enter-contest/{id}', 'Contest\ContestController@enterExam');

        Route::post('contest-course-exam/submit','Contest\ContestController@SubmitExam');
        Route::get('get-contest-result/{id}','Contest\ContestController@attemptResult');
        Route::get('get-attempts/{slug}','Contest\ContestController@getAttempts');
        Route::get('get-attempts-details/{id}','Contest\ContestController@getAttemptsDetails');

        Route::post('assemble-checkout-api','Assemble\AssembleController@checkout');

        Route::get('exam-attempts/{id}', 'Exam\ExamController@getExamAttempts');
        Route::get('user-exams', 'Exam\ExamController@userExams');
        Route::get('user-coupons', 'Coupon\CouponController@index');
        Route::get('coupon-details/{course_id}/{coupon}', 'Coupon\CouponController@getCoupon');

        // Route::get('check-subscribe/{course_id}', 'Payment\PaymentController@checkSubscribe');

        Route::get('get-user-notifications', 'Notification\NotificationController@index');
        Route::get('read-notification/{id}', 'Notification\NotificationController@show');


        Route::post('checkout', 'Payment\PaymentController@checkout');
        Route::get('get-cart-items', 'Cart\CartController@index');
        Route::post('delete-from-cart', 'Cart\CartController@removeFromCart');
        Route::post('add-to-cart', 'Cart\CartController@addToCart');
        Route::post('delete-cart', 'Cart\CartController@deleteCart');
        Route::post('apply-coupon', 'Cart\CartController@applyCoupon');
    });

    Route::group(['prefix' => 'developmental'], function () {
        Route::get('key/{key}', [DevelopmentalSettingController::class, 'getKey']);
    });
});

