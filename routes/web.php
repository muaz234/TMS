<?php

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->can_go_dashboard()) {
            return redirect('/dashboard');
        } else {
            return redirect('/home');
        }
    }
    return view('welcome');
});

// Authentication
Route::auth();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/register', function () {
    return redirect('/');
});

// Dashboard Management
Route::group(['middleware' => ['auth', 'dashboard']], function() {
    Route::get('/dashboard', function () {
        return view('dashboard.home');
    });
});

//Student Section
Route::group(['middleware' => ['auth', 'student']], function() {
    Route::get('/home', function () {
        return view('student.home');
    });
    Route::get('/topic-registration', 'Student\TopicController@index');
    Route::put('/topic-register/{id}', 'Student\TopicController@register_topic')->name('register-topic');
});

//Teacher Section
Route::group(['middleware' => ['auth', 'teacher']], function() {
    Route::get('/pending-topics', 'Teacher\TopicController@pending_topics')->name('pending-topics');
    Route::put('/approve-topic/{id}', 'Teacher\TopicController@approve')->name('approve-topic');
});
