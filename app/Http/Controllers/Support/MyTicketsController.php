<?php

namespace App\Http\Controllers\Support;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\SupportTicket;

class MyTicketsController extends Controller
{
    public function index(Request $request) {
        return view('cabinet.support.my_tickets')->with([
            'tickets' => $this->getTickets(),
        ]);
    }

    private function getTickets($count = 15) {
        return SupportTicket::where('user_id', '=', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->simplePaginate($count);
    }
}
