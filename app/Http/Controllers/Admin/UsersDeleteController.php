<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UsersDeleteController extends Controller
{
    public function delete(Request $request) {
        $user = User::find($request->route('id'));

        if (!$user) {
            return redirect()->back();
        }

        $user->delete();

        return redirect()->route('admin.users');
    }
}
