<?php

use Illuminate\Support\Facades\App;

if (!function_exists('route_locale')) {

    function route_locale($name, $parameters = [], $absolute = true) {
        $parameters = array_merge([
            'locale' => App::getLocale()
        ], $parameters);

        return route($name, $parameters, $absolute);
    }

}