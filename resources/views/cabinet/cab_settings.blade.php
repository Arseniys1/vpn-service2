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
                            <p class="text-danger">{{ __('cab.error') }}</p>
                        @endif

                        <form action="{{ route('cabinet.settings.save') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="locale">{{ __('cab.language') }}</label>
                                <select class="form-control" name="locale" id="locale">
                                    <option value="ru">Русский</option>
                                    <option value="en">English</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('cab.save') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
