@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Подтверждение способа оплаты</div>

                    <div class="card-body">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Информация о подписке</h5>
                                <p class="card-text">Подписка: {{ $paymentScore->access->name_humanity }}</p>
                                <p class="card-text">
                                    Продолжительность: {{ $paymentScore->access->duration_humanity }}</p>
                                <p class="card-text">Цена: {{ $paymentScore->access->price / 100 . ' $' }}</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Информация о способе оплаты</h5>
                                <p class="card-text">Название: {{ $paymentProvider->name }}</p>
                                <p class="card-text">Описание: {{ $paymentProvider->description }}</p>
                            </div>
                        </div>
                        <form method="post" action="{{ route('payments.way.form.post') }}" class="mt-3">
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
                                <label for="discount_code">Скидочный код</label>
                                <input type="text" class="form-control" id="discount_code" name="discount_code">

                                @if ($errors->has('discount_code'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('discount_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Подтверждаю</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
