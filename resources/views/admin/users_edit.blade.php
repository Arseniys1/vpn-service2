@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            @include('admin.admin_nav')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Редактировать пользователя</div>

                    <div class="card-body">
                        <form method="post" action="{{ route('admin.users.edit.post', ['id' => $user->id]) }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">Имя</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" aria-describedby="nameHelp" placeholder="Имя">
                                <small id="nameHelp" class="form-text text-muted"></small>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" aria-describedby="emailHelp" placeholder="E-mail">
                                <small id="emailHelp" class="form-text text-muted"></small>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password">Пароль</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Пароль">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Повторите пароль</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Повторите пароль">
                            </div>
                            <div class="form-group">
                                <label for="locale">Язык</label>
                                <select class="form-control" name="locale" id="locale">
                                    <option {{ $user->locale == 'ru' ? 'selected' : '' }} value="ru">Русский</option>
                                    <option {{ $user->locale == 'en' ? 'selected' : '' }} value="en">English</option>
                                </select>

                                @if ($errors->has('locale'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('locale') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @foreach($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $role->id }}" {{ $user->hasRole($role->name) ? 'checked' : '' }} name="roles[]" id="role-{{ $role->id }}">
                                    <label class="form-check-label" for="role-{{ $role->id }}">
                                        {{ $role->name_humanity }}
                                    </label>
                                </div>

                                @if ($errors->has('roles'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('roles') }}</strong>
                                    </span>
                                @endif
                            @endforeach
                            <button type="submit" class="btn btn-success mt-3">Создать</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
