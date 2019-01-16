@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('cab.subs') }}</div>

                    <div class="card-body">
                        @foreach(Auth::user()->access as $access)
                            @if($access->pivot->end_at > time())
                                <div class="card text-white bg-primary mb-3">
                                    <div class="card-header">{{ __($access->name_humanity) }}</div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ __('cab.duration') . __($access->duration_humanity) }}</h5>
                                        <h5 class="card-title">{{ __('cab.price') . $access->price / 100 . '$' }}</h5>
                                        <p class="card-text">
                                            <?php
                                            $now = new DateTime();
                                            $end_at = new DateTime();
                                            $end_at->setTimestamp($access->pivot->end_at);
                                            $interval = $now->diff($end_at);
                                            ?>
                                            {{ __('cab.left') . $interval->y . __('cab.years_old') . $interval->d . __('cab.days') . $interval->h . __('cab.hours') . $interval->i . __('cab.minutes') }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        @if(!Auth::user()->hasActiveAccess())
                            <a href="{{ route_locale('cabinet.tariffs') }}" class="btn btn-success">
                                {{ __('cab.buy_sub') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
