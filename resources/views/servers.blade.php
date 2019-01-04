@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header">{{ __('servers.' . $title) }}</div>

                    <div class="card-body">
                        @if(count($servers) > 0)
                            @foreach($servers as $server)
                                <div class="card mb-2">
                                    <div class="card-body">
                                        {{ $server->ip . ':' . $server->port }}
                                        {{ $server->country->name . ' ' . $server->country->iso }}
                                        <img src="{{ asset('images/countries/' . $server->country->image) }}">
                                        Online {{ $server->online_counter . '/' . $server->max_online }}
                                        @if(Auth::check() || $server->free == true)
                                            <a href="#" name="sendRequest" data-ip="{{ $server->ip }}">Получить доступ</a>
                                            <a href="{{ route('cabinet.downloadOvpnConfig', ['ip' => $server->ip]) }}" name="downloadOvpn" style="display: none;">Скачать конфигурацию</a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            {{ $servers->links() }}
                        @else
                            <p>{{ __('servers.no_servers') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
