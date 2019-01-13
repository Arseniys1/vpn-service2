@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('cabinet.support.nav')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Новый тикет</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('cabinet.support.new.ticket.post') }}">
                            @csrf

                            <div class="form-group">
                                <label for="title">Заголовок</label>
                                <input type="text" class="form-control" id="title" name="title" required>

                                @if ($errors->has('title'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="message">Ваше сообщение</label>
                                <textarea class="form-control" id="message" name="message" rows="3" required></textarea>

                                @if ($errors->has('message'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <img src="{{ captcha_src() }}" class="mr-auto ml-auto">
                            </div>

                            <div class="form-group">
                                <label for="captcha">Капча</label>
                                <input id="captcha" type="text" class="form-control" name="captcha" required>

                                @if ($errors->has('captcha'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('captcha') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Отправить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
