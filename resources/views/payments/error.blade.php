@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card text-white bg-danger">
                    <div class="card-header">{{ __('payments.after_payment_error_title') }}</div>

                    <div class="card-body">
                        @isset($paymentScore)
                            <p class="card-text"><strong>{{ __('payments.score_id', ['score_id' => $paymentScore->id]) }}</strong></p>
                        @endisset
                        <p class="card-text">{{ __('payments.contact_support') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
