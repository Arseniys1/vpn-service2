<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersEditController extends Controller
{
    public function index(Request $request) {
        $users = User::simplePaginate(15);

        return view('admin.users')->with([
            'users' => $users,
        ]);
    }
}
