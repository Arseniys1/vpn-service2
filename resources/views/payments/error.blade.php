@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Произошла ошибка</div>

                    <div class="card-body">
                        @isset($error)
                            <p class="text-danger">{{ $error }}</p>
                        @endisset
                        <p>Обратитесь в поддержку</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
