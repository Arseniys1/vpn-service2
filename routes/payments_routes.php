<?php

Route::get('{locale}/payments/way', 'Payments\WayController@index')->middleware('locale', 'auth')->name('payments.way');
Route::get('{locale}/payments/way/form', 'Payments\WayFormController@index')->middleware('locale', 'auth')->name('payments.way.form');
Route::post('{locale}/payments/way/form', 'Payments\WayFormController@post')->middleware('locale', 'auth')->name('payments.way.form.post');

Route::get('payments/callback/hunter/{service_slug}/{method}', 'Payments\CallbackHunterController@serviceCallback')->name('payments.callback.hunter.get');
Route::post('payments/callback/hunter/{service_slug}/{method}', 'Payments\CallbackHunterController@serviceCallback')->name('payments.callback.hunter');

Route::get('{locale}/payments/success', 'Payments\SuccessController@index')->middleware('locale', 'auth')->name('payments.success');
Route::get('{locale}/payments/error', 'Payments\ErrorController@index')->middleware('locale', 'auth')->name('payments.error');