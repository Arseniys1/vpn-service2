<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
    public function index(Request $request) {
        $users = User::simplePaginate(15);

        return view('admin.users')->with([
            'users' => $users,
        ]);
    }
}
