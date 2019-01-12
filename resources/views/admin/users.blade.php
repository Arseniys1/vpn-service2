@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('admin.admin_nav')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Пользователи</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Имя</th>
                                    <th scope="col">E-Mail</th>
                                    <th scope="col">E-Mail проверен</th>
                                    <th scope="col">Язык</th>
                                    <th scope="col">Создан</th>
                                    <th scope="col">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <th scope="row">{{ $user->id }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->email_verified_at }}</td>
                                        <td>{{ $user->locale }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-info dropdown-toggle" type="button" id="drop-{{ $user->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                <div class="dropdown-menu" aria-labelledby="drop-{{ $user->id }}">
                                                    <a class="dropdown-item" href="#">Редактировать</a>
                                                    <a class="dropdown-item" href="#">Удалить</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
