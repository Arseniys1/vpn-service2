<?php

use Illuminate\Http\Request;

require "public_api/vpn_servers.php";

Route::group(['prefix' => 'vpn/{token}', 'middleware' => 'vpnVerify'], function () {
    Route::post('/verify', 'Api\VpnController@verify');
    Route::post('/connect', 'Api\VpnController@connect');
    Route::post('/disconnect', 'Api\VpnController@disconnect');
    Route::post('/statistics', 'Api\VpnController@statistics');
});

Route::group(['prefix' => 'echo/{token}', 'middleware' => 'echoServerVerify'], function () {
    Route::post('/connect', 'Echoo\ConnectController@connect');
    Route::post('/create-access', 'Echoo\CreateAccessController@createAccess');
    Route::post('/delete-access', 'Echoo\DeleteAccessController@deleteAccess');
    Route::post('/not-connected', 'Echoo\NotConnectedController@notConnected');
    Route::post('/disconnect', 'Echoo\DisconnectController@disconnect');
});
