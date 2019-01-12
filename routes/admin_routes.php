<?php

Route::group(['prefix' => 'admin', 'middleware' => 'roles:admin.visible'], function () {
    Route::get('/users', 'Admin\UsersController@index')->middleware('roles:users.visible');
    Route::get('/users/edit/{id}', 'Admin\UsersEditController@index')->middleware('roles:users.visible');
});