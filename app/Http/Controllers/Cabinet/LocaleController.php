<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Route;

class LocaleController extends Controller
{
    public function changeLocale(Request $request) {
        $locales = [
            'ru',
            'en',
        ];

        if (array_search($request->route('locale'), $locales) !== false) {
            $backRoute = Route::getRoutes()->match(RequestFacade::create(redirect()->back()->getTargetUrl()));

            if ($backRoute->getName()) {
                return redirect()->route($backRoute->getName(), [
                    'locale' => $request->route('locale'),
                ]);
            }
        }

        return redirect()->back();
    }
}
