@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            @include('admin.admin_nav')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">{{ $title }}</div>

                    <div class="card-body">
                        {{ $message }}
                        @isset($url)
                            <a href="{{ $url }}" class="btn btn-primary">{{ $url_title }}</a>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
