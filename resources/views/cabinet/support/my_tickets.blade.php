@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('cabinet.support.nav')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Мои тикеты</div>

                    <div class="card-body">
                        @foreach($tickets as $ticket)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $ticket->title }}</h5>
                                    <p class="card-text">
                                        @if(strlen($ticket->body) > 200)
                                            {{ substr($ticket->body, 0, 200) . '...' }}
                                        @else
                                            {{ $ticket->body }}
                                        @endif
                                    </p>
                                    <p class="card-text mb-1">Последний ответ от:
                                        @if($ticket->messages->last() == null)
                                            {{ $ticket->user->name }}
                                        @else
                                            {{ $ticket->messages->last()->user->name }}
                                        @endif
                                    </p>
                                    <p class="card-text mb-1">
                                        @if($ticket->status == 'open')
                                            {{ 'Статус: Открыт' }}
                                        @elseif($ticket->status == 'close')
                                            {{ 'Статус: Закрыт' }}
                                        @endif
                                    </p>
                                    <a href="{{ route('cabinet.support.ticket', ['id' => $ticket->id]) }}" class="btn btn-primary">В тикет</a>
                                    @if ($ticket->client_feedback == null)
                                        <a href="{{ route('cabinet.support.ticket.send.feedback.true', ['id' => $ticket->id]) }}" class="btn btn-primary">Вопрос решен</a>
                                        <a href="{{ route('cabinet.support.ticket.send.feedback.false', ['id' => $ticket->id]) }}" class="btn btn-danger">Вопрос не решен</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        {{ $tickets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
