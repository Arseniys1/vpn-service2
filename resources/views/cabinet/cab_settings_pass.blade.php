@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('cabinet.cab_settings_nav')

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('cab.settings') }}</div>

                    <div class="card-body">
                        @if(session('success'))
                            <p class="text-success">{{ __('cab.data_save') }}</p>
                        @elseif(session('error'))
                            @if(session('error_message'))
                                <p class="text-danger">{{ session('error_message') }}</p>
                            @else
                                <p class="text-danger">{{ __('cab.error') }}</p>
                            @endif
                        @endif

                        <form action="{{ route_locale('cabinet.settings.password.save') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="password_current">{{ __('cab.password_current') }}</label>
                                <input id="password_current" type="password" class="form-control{{ $errors->has('password_current') ? ' is-invalid' : '' }}" name="password_current" required>
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('login.password') }}</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">{{ __('login.password_confirm') }}</label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('cab.save') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
