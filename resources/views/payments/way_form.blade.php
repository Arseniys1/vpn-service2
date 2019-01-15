@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('payments.way_form_title') }}</div>

                    <div class="card-body">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('payments.way_form_info_access') }}</h5>
                                <p class="card-text">
                                    {{ __('payments.way_form_access', ['name' => __($paymentScore->access->name_humanity)]) }}
                                </p>
                                <p class="card-text">
                                    {{ __('payments.way_form_access_duration', ['duration' => __($paymentScore->access->duration_humanity)]) }}
                                </p>
                                <p class="card-text">
                                    {{ __('payments.way_form_access_price', ['price' => $paymentScore->access->price / 100]) }}
                                </p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('payments.way_form_info_payment') }}</h5>
                                <p class="card-text">
                                    {{ __('payments.way_form_payment', ['name' => __($paymentProvider->name)]) }}
                                </p>
                                <p class="card-text">
                                    {{ __('payments.way_form_payment_description', ['description' => __($paymentProvider->description)]) }}
                                </p>
                            </div>
                        </div>
                        <form method="post" action="{{ route_locale('payments.way.form.post') }}" class="mt-3">
                            @csrf

                            <input type="hidden" name="score_id" value="{{ $paymentScore->id }}">
                            <input type="hidden" name="provider_id" value="{{ $paymentProvider->id }}">

                            @if ($errors->has('score_id'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('score_id') }}</strong>
                                </span>
                            @endif

                            @if ($errors->has('provider_id'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('provider_id') }}</strong>
                                </span>
                            @endif

                            <div class="form-group">
                                <label for="discount_code">{{ __('payments.way_form_discount') }}</label>
                                <input type="text" class="form-control" id="discount_code" name="discount_code">

                                @if ($errors->has('discount_code'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('discount_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('payments.way_form_confirm') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
