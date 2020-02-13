<?php

Route::get('/', 'Cabinet\CabinetController@index')->middleware('locale', 'auth')->name('index');

Route::get('{locale}/cabinet', 'Cabinet\CabinetController@index')->middleware('locale', 'auth')->name('cabinet.index');

Route::get('locale/{locale}', 'Cabinet\LocaleController@changeLocale')->name('locale.change');

Route::get('{locale}/cabinet/settings', 'Cabinet\SettingsController@index')->middleware('locale', 'auth')->name('cabinet.settings');
Route::post('{locale}/cabinet/settings', 'Cabinet\SettingsController@save')->middleware('locale', 'auth')->name('cabinet.settings.save');
Route::get('{locale}/cabinet/settings/password', 'Cabinet\SettingsPassController@index')->middleware('locale', 'auth')->name('cabinet.settings.password');
Route::post('{locale}/cabinet/settings/password', 'Cabinet\SettingsPassController@save')->middleware('locale', 'auth')->name('cabinet.settings.password.save');
//Route::get('{locale}/cabinet/settings/password/two', 'Cabinet\SettingsTwoFactController@index')->name('cabinet.settings.password.two');
//Route::post('{locale}/cabinet/settings/password/two', 'Cabinet\SettingsTwoFactController@save')->name('cabinet.settings.password.two.save');
Route::get('{locale}/cabinet/tariffs', 'Cabinet\TariffsController@index')->middleware('locale', 'auth')->name('cabinet.tariffs');
Route::get('{locale}/cabinet/tariffs/score/{access_id}', 'Cabinet\TariffsController@createPaymentScore')->middleware('locale', 'auth')->name('cabinet.tariffs.score');

Route::get('{locale}/vpn/path/configure', 'Cabinet\VpnPathController@index')->middleware('locale', 'auth')->name('cabinet.vpn.path');

Route::get('/cabinet/download/config/{ip}', 'Cabinet\CabinetController@downloadConfig')->middleware('auth')->name('cabinet.download.config');

Route::get('/{locale}/servers', 'ServersController@index')->middleware('locale')->name('servers.index');
Route::get('/{locale}/servers/free', 'ServersController@free')->middleware('locale')->name('servers.free');
Route::post('/servers/create/access', 'ServersAccessController@createAccess')->middleware('auth')->name('servers.create.access');
Route::post('/servers/remove/access', 'ServersAccessController@removeAccess')->middleware('auth')->name('servers.remove.access');
Route::post('/servers/check/response', 'ServersAccessController@checkResponse')->middleware('auth')->name('servers.check.response');