<?php

Route::group(['prefix' => 'payments'], function () {
    Route::get('/way', 'Payments\WayController@index')->middleware('auth')->name('payments.way');
    Route::get('/way/form', 'Payments\WayFormController@index')->middleware('auth')->name('payments.way.form');
    Route::post('/way/form', 'Payments\WayFormController@post')->middleware('auth')->name('payments.way.form.post');

    Route::post('/callback/hunter/{service_slug}/{method}', 'Payments\CallbackHunterController@serviceCallback')->name('payments.callback.hunter');
});