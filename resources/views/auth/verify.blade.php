@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('login.verify_title') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('login.verify_send_new_link') }}
                        </div>
                    @endif

                    {{ __('login.verify_check_email') }}
                    {{ __('login.verify_no_mail') }}, <a href="{{ route_locale('verification.resend') }}">{{ __('login.verify_new_request') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
