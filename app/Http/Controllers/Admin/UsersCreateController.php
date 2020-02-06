<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersCreateController extends Controller
{
    public function index(Request $request) {
        return view('admin.users_create')->with([
            'roles' => Role::get(),
        ]);
    }

    public function create(Request $request) {
        $v = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'locale' => 'required|string|in:ru,en',
            'roles' => 'array',
            'roles.*' => 'integer|exists:roles,id',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withInput()->withErrors($v);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->vpn_username = Str::random(30);
        $user->vpn_password = Str::random(30);
        $user->locale = $request->input('locale');
        $user->save();

        if ($request->input('roles') != null) {
            $userRoles = [];

            foreach ($request->input('roles') as $roleId) {
                $userRoles[] = [
                    'user_id' => $user->id,
                    'role_id' => $roleId,
                ];
            }

            if (count($userRoles) > 0) {
                DB::table('user_roles')->insert($userRoles);
            }
        }

        return view('admin.after_action')->with([
            'title' => 'Пользователь создан',
            'message' => 'Пользователь создан',
            'url' => route('admin.users.edit', ['id' => $user->id]),
            'url_title' => 'Редактировать',
        ]);
    }
}
