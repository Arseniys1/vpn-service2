@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('cabinet.support.nav')

            <div class="col-md-10">
                <div class="card mb-3">
                    <div class="card-header">Тикет #{{ $ticket->id }}</div>

                    <div class="card-body">
                        <h5 class="card-title">{{ $ticket->title }}</h5>
                        <p class="card-text">
                            {{ $ticket->body }}
                        </p>
                        <p class="card-text mb-1">
                            @if($ticket->status == 'open')
                                {{ 'Статус: Открыт' }}
                            @elseif($ticket->status == 'close')
                                {{ 'Статус: Закрыт' }}
                            @endif
                        </p>
                        @if($ticket->client_feedback == null)
                            <a href="{{ route('cabinet.support.ticket.send.feedback.true', ['id' => $ticket->id]) }}" class="btn btn-primary">Вопрос решен</a>
                            <a href="{{ route('cabinet.support.ticket.send.feedback.false', ['id' => $ticket->id]) }}" class="btn btn-danger">Вопрос не решен</a>
                        @endif
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-header">Сообщения</div>

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
                        <form method="POST" action="{{ route('cabinet.support.ticket.send.message', ['id' => $ticket->id]) }}">
                            @csrf

                            <div class="form-group">
                                <label for="messageBody">Ваше сообщение</label>
                                <textarea class="form-control" id="messageBody" name="message" rows="3"></textarea>

                                @if ($errors->has('message'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Отправить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
