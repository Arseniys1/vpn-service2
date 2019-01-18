<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsersEditController extends Controller
{
    public function index(Request $request) {
        $user = User::find($request->route('id'));

        if (!$user) {
            return redirect()->back();
        }

        return view('admin.users_edit')->with([
            'user' => $user,
            'roles' => Role::get(),
        ]);
    }

    public function edit(Request $request) {
        $v = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'string|min:6|confirmed|nullable',
            'locale' => 'required|string|in:ru,en',
            'roles' => 'array',
            'roles.*' => 'integer|exists:roles,id',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withInput()->withErrors($v);
        }

        $user = User::find($request->route('id'));

        if (!$user) {
            return redirect()->back();
        }

        $user->name = $request->input('name');

        if ($user->email != $request->input('email')) {
            if (User::where('email', '=', $request->input('email'))->first()) {
                return redirect()->back()->withInput()->withErrors($v);
            }

            $user->email = $request->input('email');
        }

        if ($request->input('password') != null) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->locale = $request->input('locale');
        $user->save();

        DB::table('user_roles')->where('user_id', '=', $user->id)->delete();

        if ($request->has('roles') != null) {
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
            'title' => 'Пользователь изменен',
            'message' => 'Пользователь изменен',
            'url' => route('admin.users'),
            'url_title' => 'Пользователи',
        ]);
    }
}
