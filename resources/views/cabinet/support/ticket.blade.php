@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('cabinet.support.nav')

            <div class="col-md-10">
                <div class="card mb-3">
                    <div class="card-header">
                        {{ __('support.ticket_title', ['ticket' => $ticket->id]) }}
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">{{ $ticket->title }}</h5>
                        <p class="card-text">
                            {{ $ticket->body }}
                        </p>
                        <p class="card-text mb-1">
                            @if($ticket->status == 'open')
                                {{ __('support.status', ['status' => __('support.open_status')]) }}
                            @elseif($ticket->status == 'close')
                                {{ __('support.status', ['status' => __('support.close_status')]) }}
                            @endif
                        </p>
                        @if($ticket->client_feedback == null)
                            <a href="{{ route_locale('cabinet.support.ticket.send.feedback.true', ['id' => $ticket->id]) }}" class="btn btn-primary">{{ __('support.issue_true') }}</a>
                            <a href="{{ route_locale('cabinet.support.ticket.send.feedback.false', ['id' => $ticket->id]) }}" class="btn btn-danger">{{ __('support.issue_false') }}</a>
                        @endif
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-header">{{ __('support.ticket_messages') }}</div>

                    <div class="card-body">
                        @foreach($ticket->messages as $message)
                            <div class="card mb-2 {{ Auth::user()->id == $message->user_id ? 'bg-primary text-white' : '' }}">
                                <div class="card-body">
                                    <p>{{ $message->user->name }} {{ date('Y.m.d G:i', strtotime($message->created_at)) }}</p>
                                    {{ $message->body }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route_locale('cabinet.support.ticket.send.message', ['id' => $ticket->id]) }}">
                            @csrf

                            <div class="form-group">
                                <label for="messageBody">{{ __('support.ticket_message') }}</label>
                                <textarea class="form-control" id="messageBody" name="message" rows="3"></textarea>

                                @if ($errors->has('message'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('support.ticket_send') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
