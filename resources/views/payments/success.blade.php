@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card text-white bg-success">
                    <div class="card-header">{{ __('payments.success_title') }}</div>

                    <div class="card-body">
                        @isset($paymentScore)
                            <p class="card-text"><strong>{{ __('payments.score_id', ['score_id' => $paymentScore->id]) }}</strong></p>
                            <p class="card-text mb-1">{{ __('payments.tariff', ['tariff' => __($paymentScore->access->name_humanity)]) }}</p>
                            <p class="card-text mb-1">{{ __('payments.duration', ['duration' => __($paymentScore->access->duration_humanity)]) }}</p>
                            <p class="card-text">{{ __('payments.description', ['description' => __($paymentScore->access->description)]) }}</p>
                        @endisset
                        <p class="card-text mb-1">{{ __('payments.subscription_activated') }}</p>
                        <p class="card-text">{{ __('payments.contact_support') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
