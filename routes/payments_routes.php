<?php

Route::group(['prefix' => 'payments', 'middleware' => 'auth'], function () {
    Route::get('/way', 'Payments\WayController@index')->name('payments.way');
    Route::get('/way/form', 'Payments\WayFormController@index')->name('payments.way.form');
    Route::post('/way/form', 'Payments\WayFormController@post')->name('payments.way.form.post');
});