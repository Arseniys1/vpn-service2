<?php

Route::get('{locale}/payments/way', 'Payments\WayController@index')->middleware('locale', 'auth')->name('payments.way');
Route::get('{locale}/payments/way/form', 'Payments\WayFormController@index')->middleware('locale', 'auth')->name('payments.way.form');
Route::post('{locale}/payments/way/form', 'Payments\WayFormController@post')->middleware('locale', 'auth')->name('payments.way.form.post');

Route::post('payments/callback/hunter/{service_slug}/notification', 'Payments\CallbackHunterController@serviceCallback')->name('payments.callback.hunter');