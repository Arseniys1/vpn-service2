<?php

Route::get('login', 'Auth\LoginController@showLoginForm')->middleware('locale')->name('login');
Route::post('login', 'Auth\LoginController@login')->middleware('locale');
Route::post('logout', 'Auth\LoginController@logout')->middleware('locale')->name('logout');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->middleware('locale')->name('register');
Route::post('register', 'Auth\RegisterController@register')->middleware('locale');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->middleware('locale')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->middleware('locale')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->middleware('locale')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->middleware('locale')->name('password.update');

Route::get('email/verify', 'Auth\VerificationController@show')->middleware('locale')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->middleware('locale')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->middleware('locale')->name('verification.resend');