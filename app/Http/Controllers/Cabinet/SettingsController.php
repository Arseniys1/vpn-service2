<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        return view('cabinet.cab_settings');
    }

    public function save(Request $request)
    {
        $v = Validator::make($request->all(), [
            'locale' => 'required|string|in:ru,en',
        ]);

        if ($v->fails()) {
            return redirect()->route('cabinet.settings', ['locale' => App::getLocale()])->with([
                'error' => true,
            ]);
        }

        $user = Auth::user();
        $user->locale = $request->input('locale');
        $user->save();

        return redirect()->route('cabinet.settings', ['locale' => App::getLocale()])->with([
            'success' => true,
        ]);
    }
}
