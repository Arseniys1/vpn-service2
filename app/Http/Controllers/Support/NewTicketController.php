<?php

namespace App\Http\Controllers\Support;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\SupportTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class NewTicketController extends Controller
{
    public function index(Request $request) {
        return view('cabinet.support.new_ticket');
    }

    public function newTicket(Request $request) {
        $v = Validator::make($request->all(), [
            'title' => 'required|string|min:1|max:250',
            'message' => 'required|string|min:1|max:5000',
            'captcha' => 'required|captcha',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v);
        }

        $ticket = new SupportTicket();
        $ticket->user_id = Auth::user()->id;
        $ticket->title = $request->input('title');
        $ticket->body = $request->input('message');
        $ticket->status = 'open';
        $ticket->save();

        return redirect()->route('cabinet.support.my_tickets', ['locale' => App::getLocale()]);
    }
}
