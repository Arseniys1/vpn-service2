@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Тарифы</div>

                    <div class="card-body">
                        <div class="row">
                        @foreach($tariffs as $tariff)
                            <div class="col-md-4">
                                <div class="card {{ $tariff->class }} mb-3">
                                    <div class="card-header">{{ __($tariff->name_humanity) }}</div>
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2">Продолжительность: {{ __($tariff->duration_humanity) }}</h6>
                                        <p class="card-text">{{ __($tariff->description) }}</p>
                                        <h6 class="card-subtitle mb-3">Цена: {{ $tariff->price / 100 }} $</h6>
                                        <a href="{{ route('cabinet.tariffs.score', ['access_id' => $tariff->id]) }}" class="btn btn-success w-100">Купить</a>
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
