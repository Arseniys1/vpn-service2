@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('cabinet.support.nav')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Ошибка</div>

                    <div class="card-body">
                        <div class="alert alert-danger" role="alert">
                            Тикет не найден.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
