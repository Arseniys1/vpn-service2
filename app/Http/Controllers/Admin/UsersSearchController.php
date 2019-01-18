<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;

class UsersSearchController extends Controller
{
    public function index(Request $request) {
        $v = Validator::make($request->all(), [
            'searchFor' => 'required|string|in:id,text_id,name,email',
            'searchValue' => 'required|string',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v);
        }

        $users = User::where($request->input('searchFor'), 'like', '%' . $request->input('searchValue') . '%')->simplePaginate(15);

        return view('admin.users')->with([
            'users' => $users,
            'backButton' => true,
        ]);
    }
}
