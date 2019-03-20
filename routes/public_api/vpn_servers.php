<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'vpn-servers/{token}', 'middleware' => 'publicApiVerify'], function () {
    Route::get('/getServers', 'Api\PublicApi\VpnServers\GetServers@getServers');
    Route::get('/getOvpnConfig', 'Api\PublicApi\VpnServers\GetOvpnConfig@getOvpnConfig');
    Route::get('/createAccess', 'Api\PublicApi\VpnServers\CreateAccess@createAccess');
    Route::get('/checkEvent', 'Api\PublicApi\VpnServers\CheckEvent@checkEvent');
    Route::get('/removeAccess', 'Api\PublicApi\VpnServers\RemoveAccess@removeAccess');
    Route::get('/getServersAccess', 'Api\PublicApi\VpnServers\GetServersAccess@getServersAccess');
});

