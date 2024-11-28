<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {

    Route::middleware(['auth:admin','CheckTeacher'])->group(function () {
        Route::resource('passed-exams', 'PassedExamsController');
        Route::post('send-gift', 'PassedExamsController@sendGift')->name('send-gift');
        Route::resource('teacher-courses', 'CourseController');
        Route::resource('content-courses', 'CourseContentController');
        Route::resource('content-comments', 'ContentCommentsContentController');
        Route::resource('content-categories', 'ContentCategoryContentController');
        Route::resource('content-categories-questions', 'ContentCategoryQuestionsController');
        Route::get('content-categories-questions-create/{id}', 'ContentCategoryQuestionsController@CreateQuestions')->name('content-categories-questions-create');



        Route::get('content-courses-units/{id}', 'CourseContentController@CourseUnits')->name('course-units');
        Route::resource('content-results', 'ContentResultsContentController');
        Route::get('content_answers/{content_id}', 'ExamsContentController@studentAnswers')->name('content_answers');
        Route::delete('content_answers/delete/{attempt_id}', 'ExamsContentController@destroy')->name('content_answers.delete');
        Route::get('content_answers/{content_id}/notification', 'ExamsContentController@notifyStudent')->name('content_answers.notify');
        Route::put('content_answer/{answer_id}', 'ExamsContentController@AnswerUpdate')->name('content_answer.update');
        Route::get('content_answer/{answer_id}', 'ExamsContentController@studentAnswer')->name('content_answer');


        Route::get('content-questions/{id}', 'CourseContentQuestionsController@show')->name('content.questions');
        Route::get('content-questions-create/{id}', 'CourseContentQuestionsController@CreateQuestions')->name('content.questions.create');
        Route::post('content-questions-store', 'CourseContentQuestionsController@store')->name('content.questions.store');
        Route::put('content-questions-update/{id}', 'CourseContentQuestionsController@update')->name('content.questions.update');
        Route::get('content-questions-edit/{id}', 'CourseContentQuestionsController@edit')->name('content.questions.edit');
        Route::delete('content-questions/{id}', 'CourseContentQuestionsController@destroy')->name('content.questions.destroy');


        Route::get('exam-question/{teacher_id}/{exam_id}', 'PassedExamsController@ExamQuestions')->name('exam.questions');
        Route::get('create-exam/{teacher_id}/{exam_id}', 'PassedExamsController@createExam')->name('teacher.create.passed');
        Route::resource('questions', 'QuestionsController');
        Route::get('students_attempts/{attempt_id}', 'ExamsAttemptController@show')->name('students_attempts');
        Route::get('students_answers/{attempt_id}', 'ExamsAttemptController@studentAnswers')->name('students_answers');
        Route::get('students_answer/{answer_id}', 'ExamsAttemptController@studentAnswer')->name('students_answer');
        Route::put('answer/{answer_id}', 'ExamsAttemptController@AnswerUpdate')->name('answer.update');
        Route::delete('student_attempt/delete/{attempt_id}', 'ExamsAttemptController@destroy')->name('student_attempt.delete');
        Route::post('get_subjects', 'SubjectController@getSubjects')->name('get_subjects');
    });

});
