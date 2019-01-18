<?php

Route::group(['prefix' => 'admin', 'middleware' => 'roles:admin'], function () {
    Route::get('/', function () {
        return redirect()->route('admin.users');
    })->name('admin');

    Route::get('/users', 'Admin\UsersController@index')->middleware('roles:users')->name('admin.users');
    Route::get('/users/search', 'Admin\UsersSearchController@index')->middleware('roles:users')->name('admin.users.search');
    Route::get('/users/create', 'Admin\UsersCreateController@index')->middleware('roles:users.create')->name('admin.users.create');
    Route::post('/users/create', 'Admin\UsersCreateController@create')->middleware('roles:users.create')->name('admin.users.create.post');
    Route::get('/users/edit/{id}', 'Admin\UsersEditController@index')->middleware('roles:users.edit')->name('admin.users.edit');
    Route::post('/users/edit/{id}', 'Admin\UsersEditController@edit')->middleware('roles:users.edit')->name('admin.users.edit.post');
    Route::post('/users/delete/{id}', 'Admin\UsersDeleteController@delete')->middleware('roles:users.delete')->name('admin.users.delete');

    Route::get('/payments', 'Admin\PaymentsController@index')->middleware('roles:payments')->name('admin.payments');
    Route::get('/payments/search', 'Admin\PaymentsSearchController@index')->middleware('roles:payments')->name('admin.payments.search');
    Route::get('/payments/detail/{score_id}', 'Admin\PaymentsDetailController@index')->middleware('roles:payments.detail')->name('admin.payments.detail');

    Route::get('/payments/providers', 'Admin\PaymentsDetailController@index')->middleware('roles:payments.providers')->name('admin.payments.providers');
});