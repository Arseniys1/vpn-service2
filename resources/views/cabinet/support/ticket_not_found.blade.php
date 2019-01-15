@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('cabinet.support.nav')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('support.ticket_not_found_title') }}</div>

                    <div class="card-body">
                        <div class="alert alert-danger" role="alert">
                            {{ __('support.ticket_not_found_message') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
