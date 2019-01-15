@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('payments.error_title') }}</div>

                    <div class="card-body">
                        @isset($error)
                            <p class="text-danger">{{ __($error) }}</p>
                        @endisset
                        <p>{{ __('payments.error_contact_support') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
