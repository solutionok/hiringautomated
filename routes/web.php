<?php

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

/**
 * frontend routes
 */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::view('/home/about', 'home.about', ['pageClass'=>'about-us']);
Route::view('/home/product', 'home.product', ['pageClass'=>'product']);

Route::get('/register/emailcheck/{email}', 'Auth\RegisterController@mailchk');

//interview
Route::get('/home/interview', 'HomeController@interview');
Route::get('/home/interview/{interviewId}', 'HomeController@run');
Route::post('/home/runsave', 'HomeController@runsave');
Route::get('/home/review/{id}/{step?}', 'HomeController@review');

//my for candiate
Route::get('/home/mypage', 'HomeController@mypage')->middleware('auth');
Route::post('/home/emailcheck', 'HomeController@emailcheck')->middleware('auth');
Route::post('/home/mysave', 'HomeController@mysave')->middleware('auth');
Route::post('/home/passchange', 'HomeController@passchange')->middleware('auth');
Route::post('/home/uploadcv', 'HomeController@uploadcv');

/**
 * Backend routes
 */
//admin dashboard
Route::get('/admin', 'Admin\DashboardController@index')->middleware(['assessor']);
Route::get('/admin/dashboard', 'Admin\DashboardController@index')->middleware(['assessor']);

//admin settings
Route::get('/admin/settings', 'Admin\SettingsController@index');
Route::post('/admin/settings/account', 'Admin\SettingsController@account');
Route::post('/admin/settings/password', 'Admin\SettingsController@password');
Route::post('/admin/settings/checkpass', 'Admin\SettingsController@checkpass');

//interview manage
Route::get('/admin/interview', 'Admin\InterviewController@index')->middleware(['admin']);
Route::post('/admin/interview', 'Admin\InterviewController@saveInterview')->middleware(['admin']);
Route::get('/admin/interview/delete', 'Admin\InterviewController@deleteInterview')->middleware(['admin']);
Route::get('/admin/interview/toggle', 'Admin\InterviewController@toggle')->middleware(['admin']);;

//quiz manage
Route::get('/admin/quiz', 'Admin\QuizController@index')->middleware(['admin']);;
Route::post('/admin/quiz', 'Admin\QuizController@saveQuiz')->middleware(['admin']);;
Route::get('/admin/quiz/getquiz/{quizid}', 'Admin\QuizController@getQuiz')->middleware(['admin']);;
Route::get('/admin/quiz/delete', 'Admin\QuizController@deleteQuiz')->middleware(['admin']);
Route::get('/admin/quiz/moveq/{id}', 'Admin\QuizController@moveq')->middleware(['admin']);


//review interview
Route::get('/admin/review', 'Admin\ReviewController@index');
Route::get('/admin/review/exportcsv', 'Admin\ReviewController@exportcsv');
Route::get('/admin/review/{id}/{step?}', 'Admin\ReviewController@viewInterview');
Route::post('/admin/review/historyinfo', 'Admin\ReviewController@historyinfo');
Route::post('/admin/review/evaluate', 'Admin\ReviewController@setGrade')->middleware(['assessor']);
Route::post('/admin/review/delete', 'Admin\ReviewController@removeHistory')->middleware(['assessor']);


//assessor manage
Route::get('/admin/assessor', 'Admin\AssessorController@index')->middleware(['admin']);
Route::post('/admin/assessor', 'Admin\AssessorController@saveAssessor')->middleware(['admin']);
Route::post('/admin/assessor/remove', 'Admin\AssessorController@remove')->middleware(['admin']);
Route::post('/admin/assessor/emailcheck', 'Admin\AssessorController@emailcheck')->middleware(['admin']);

//candidate manage
Route::get('/admin/candidate', 'Admin\CandidateController@index')->middleware(['admin']);
Route::get('/admin/candidate/view', 'Admin\CandidateController@view')->middleware(['admin']);
Route::post('/admin/candidate/delete', 'Admin\CandidateController@remove')->middleware(['admin']);
Route::post('/admin/candidate/save', 'Admin\CandidateController@save')->middleware(['admin']);
Route::post('/admin/candidate/emailcheck', 'Admin\CandidateController@emailcheck')->middleware(['admin']);
Route::post('/admin/candidate/bulkadd', 'Admin\CandidateController@bulkadd')->middleware(['admin']);
Route::post('/admin/candidate/assign', 'Admin\CandidateController@assignInterview')->middleware(['admin']);
Route::post('/admin/candidate/uploadcv', 'Admin\CandidateController@uploadcv')->middleware(['admin']);
Route::get('/admin/candidate/downcsv', 'Admin\CandidateController@downcsv')->middleware(['admin']);
Route::post('/admin/candidate/assessors/{interivewId}', 'Admin\CandidateController@assessors')->middleware(['admin']);

Route::prefix('messenger')->group(function () {
    Route::get('t/{id}', 'MessageController@laravelMessenger')->name('messenger');
    Route::post('send', 'MessageController@store')->name('message.store');
    Route::get('threads', 'MessageController@loadThreads')->name('threads');
    Route::get('more/messages', 'MessageController@moreMessages')->name('more.messages');
    Route::delete('delete/{id}', 'MessageController@destroy')->name('delete');
    // AJAX requests.
    Route::prefix('ajax')->group(function () {
        Route::post('make-seen', 'MessageController@makeSeen')->name('make-seen');
    });
});


Route::get('logout', function() {
    Auth::logout();
    return redirect('/');
});
Auth::routes();
