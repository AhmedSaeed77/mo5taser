<?php

use App\Http\Controllers\Admin\Filter\FilterController;
use App\Http\Controllers\Admin\User\UserMessagesController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::middleware(['guest:admin'])->group(function () {
        Route::get('login','Auth\AuthAdminController@showLoginForm')->name('admin.login');
        Route::post('login', 'Auth\AuthAdminController@login')->name('admin.login.submit');
    });
    Route::middleware(['admin.auth'])->group(function () {
        Route::get('logout', 'Auth\AuthAdminController@logout')->name('admin.logout');
        Route::get('/', 'Admin\AdminController@index')->name('admin.dashboard');
        Route::get('user/{id}', 'Admin\AdminController@edit')->name('admin.edit.user');
        Route::put('user/{id}', 'Admin\AdminController@update')->name('admin.update.user');
        Route::resource('students-progress', 'Course\ProgressController');
        Route::post('student-certificate', 'Course\ProgressController@studentCertificate')->name('student.certificate');

        Route::middleware(['CheckAdmin'])->group(function ()
        {
            Route::get('filter/{filterable}', [FilterController::class, 'show'])->name('admin.filter');
            Route::post('filter/{filterable}/export', [FilterController::class, 'export'])->name('admin.filter.export');
            Route::post('filter/{filterable}', [FilterController::class, 'filter']);
            Route::resource('courses', 'Course\CourseController');
            Route::post('copy_content/{id}', 'Course\CopyCourseController@copyCourse')->name('copy_content');
            Route::resource('coupon', 'Course\CouponController');
            Route::resource('question_answer', 'Course\QuestionAnswersController');
            Route::resource('students_results', 'Course\StudentsResultsController');
            Route::resource('rating', 'Rating\RatingController');
            Route::resource('about', 'About\AboutController');
            Route::resource('image', 'Image\ImageController');
            Route::resource('team', 'Team\TeamController');
            Route::resource('join', 'Join\JoinController')->only(['index','show','destroy']);
            Route::resource('info', 'Info\InfoController');
            Route::resource('slider', 'Slider\SliderController');
            Route::resource('spec', 'Spec\SpecController');
            Route::resource('why-us', 'WhyUs\WhyUsController');
            Route::resource('testimonail', 'Testimonail\TestimonailController');
            Route::resource('news', 'News\NewsController');
            Route::get('category/{type}', 'Category\CategoryController@CategoryByType')->name('category.type');
            Route::resource('category', 'Category\CategoryController');
            Route::resource('contact', 'Contact\ContactController');
            Route::resource('subject', 'Subject\SubjectController');
            Route::resource('assemble', 'Assemble\AssembleController');
            Route::resource('assembles-requests', 'Assemble\AssembleRequestsController')->except(['update','create','edit','store']);
            Route::resource('store', 'Store\StoreController')->except(['create', 'show']);
            Route::resource('store-requests', 'Store\StoreRequestsController')->except(['update','create','edit','store']);
            Route::post('get_childs', 'Assemble\AssembleController@getLevels')->name('get_childs');
            Route::resource('bank', 'Bank\BankController');
            Route::resource('users', 'User\UserController');
            Route::resource('admins', 'User\AdminController');
            Route::resource('privacy', 'Privacy\PrivacyController');
            Route::resource('term', 'Term\TermController');
//            Route::resource('user-messages', 'User\UserMessagesController')->only(['index', 'store']);
            Route::resource('pass', 'PassExam\PassExamController');
            Route::resource('pass-contest', 'PassContest\PassContestController');
            Route::post('get_levels', 'PassExam\PassExamController@getLevels')->name('get_levels');

            Route::get('subscribes-courses/{slug}', 'Subscribe\SubscribeController@subscribes')->name('subscribes-courses');
            Route::get('subscribes-search', 'Subscribe\SubscribeController@search')->name('subscribes-search');
            Route::resource('subscribes', 'Subscribe\SubscribeController');


            Route::resource('free-subscribe', 'Subscribe\FreeSubscribeController')->only('show','update');
            Route::get('users-export', 'Export\ExportController@exportUsers')->name('user-exports');
            Route::get('subscribes-export', 'Export\ExportController@exportSubscribes')->name('subscribe-exports');

            Route::resource('exchange', 'Exchange\ExchangeController')->except(['store']);
        });
    });

});
