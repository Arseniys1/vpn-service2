@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('payments.way_title') }}</div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($providers as $provider)
                                <div class="col-md-4 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ __($provider->name) }}</h5>
                                            <p class="card-text">{{ __($provider->description) }}</p>
                                        </div>
                                        <div class="card-body">
                                            <a href="{{ route_locale('payments.way.form', ['score_id' => $score->id, 'provider_id' => $provider->id]) }}" class="card-link">{{ __('payments.way_choose_payment_method') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
