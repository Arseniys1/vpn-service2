<?php

Route::get('{locale}/login', 'Auth\LoginController@showLoginForm')->middleware('locale')->name('login');
Route::post('{locale}/login', 'Auth\LoginController@login')->middleware('locale');
Route::post('{locale}/logout', 'Auth\LoginController@logout')->middleware('locale')->name('logout');

Route::get('{locale}/register', 'Auth\RegisterController@showRegistrationForm')->middleware('locale')->name('register');
Route::post('{locale}/register', 'Auth\RegisterController@register')->middleware('locale');

Route::get('{locale}/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->middleware('locale')->name('password.request');
Route::post('{locale}/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->middleware('locale')->name('password.email');
Route::get('{locale}/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->middleware('locale')->name('password.reset');
Route::post('{locale}/password/reset', 'Auth\ResetPasswordController@reset')->middleware('locale')->name('password.update');

Route::get('{locale}/email/verify', 'Auth\VerificationController@show')->middleware('locale')->name('verification.notice');
Route::get('{locale}/email/verify/{id}', 'Auth\VerificationController@verify')->middleware('locale')->name('verification.verify');
Route::get('{locale}/email/resend', 'Auth\VerificationController@resend')->middleware('locale')->name('verification.resend');