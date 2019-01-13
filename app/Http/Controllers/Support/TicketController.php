<?php

namespace App\Http\Controllers\Support;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SupportTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\SupportTicketMessage;

class TicketController extends Controller
{
    public function index(Request $request) {
        $ticket = SupportTicket::where('id', '=', $request->route('id'))
            ->where('user_id', '=', Auth::user()->id)
            ->first();

        if (!$ticket) {
            return view('cabinet.support.ticket_not_found');
        }

        return view('cabinet.support.ticket')->with([
            'ticket' => $ticket,
        ]);
    }

    public function sendMessage(Request $request) {
        $v = Validator::make($request->all(), [
            'message' => 'required|string|min:1|max:5000',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v);
        }

        $ticket = SupportTicket::where('id', '=', $request->route('id'))
            ->where('user_id', '=', Auth::user()->id)
            ->where('status', '=', 'open')
            ->first();

        if (!$ticket) {
            return redirect()->back();
        }

        $message = new SupportTicketMessage();
        $message->ticket_id = $ticket->id;
        $message->user_id = Auth::user()->id;
        $message->body = $request->input('message');
        $message->save();

        return redirect()->back();
    }

    public function feedbackTrue(Request $request) {
        $ticket = SupportTicket::where('id', '=', $request->route('id'))
            ->where('user_id', '=', Auth::user()->id)
            ->first();

        if (!$ticket) {
            return redirect()->back();
        }

        $ticket->client_feedback = 'true';
        $ticket->status = 'close';
        $ticket->save();

        return redirect()->back();
    }

    public function feedbackFalse(Request $request) {
        $ticket = SupportTicket::where('id', '=', $request->route('id'))
            ->where('user_id', '=', Auth::user()->id)
            ->first();

        if (!$ticket) {
            return redirect()->back();
        }

        $ticket->client_feedback = 'false';
        $ticket->status = 'close';
        $ticket->save();

        return redirect()->back();
    }
}
