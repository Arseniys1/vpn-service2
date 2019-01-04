<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsPassController extends Controller
{
    public function index(Request $request) {
        return view('cabinet.cab_settings_pass');
    }

    public function save(Request $request) {
        $v = Validator::make($request->all(), [
            'password_current' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($v->fails()) {
            return redirect()->back()->with([
                'error' => true,
                'error_message' => 'Ошибка валидации',
            ])->withErrors($v);
        }

        if (!Hash::check($request->input('password_current'), Auth::user()->password)) {
            return redirect()->back()->with([
                'error' => true,
                'error_message' => 'Неверный текущий пароль',
            ]);
        }

        $user = Auth::user();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->back()->with([
            'success' => true,
        ]);
    }
}
