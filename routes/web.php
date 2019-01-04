<?php

require_once 'auth_routes.php';

Route::get('/', function () {
    return redirect()->route('cabinet.index', ['locale' => App::getLocale()]);
});

Route::get('/send', function () {
    event(new \App\Events\CreateAccessEvent('1', '127.0.0.1', 1));
});

Route::get('/{locale}', 'Cabinet\CabinetController@index')->middleware('locale')->name('cabinet.index');

Route::get('/cabinet', 'Cabinet\CabinetController@index')->name('cabinet');

Route::get('/cabinet/settings', 'Cabinet\SettingsController@index')->name('cabinet.settings');
Route::post('/cabinet/settings', 'Cabinet\SettingsController@save')->name('cabinet.settings.save');
Route::get('/cabinet/settings/password', 'Cabinet\SettingsPassController@index')->name('cabinet.settings.password');
Route::post('/cabinet/settings/password', 'Cabinet\SettingsPassController@save')->name('cabinet.settings.password.save');
//Route::get('/cabinet/settings/password/two', 'Cabinet\SettingsTwoFactController@index')->name('cabinet.settings.password.two');
//Route::post('/cabinet/settings/password/two', 'Cabinet\SettingsTwoFactController@save')->name('cabinet.settings.password.two.save');

Route::get('/cabinet/downloadOvpnConfig/{server_id}', 'Cabinet\CabinetController@downloadOvpnConfig')->name('cabinet.downloadOvpnConfig');

Route::get('/{locale}/servers', 'ServersController@index')->middleware('locale')->name('servers.index');
Route::get('/{locale}/servers/free', 'ServersController@free')->middleware('locale')->name('servers.free');
Route::post('/servers/create/access', 'ServersAccessController@sendAccess')->middleware('auth')->name('servers.create.access');
