@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            @include('admin.admin_nav')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Пользователи</div>

                    <div class="card-body">
                        <div class="w-100 mb-3">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-success">Создать пользователя</a>
                        </div>

                        <form method="get" action="{{ route('admin.users.search') }}" class="form-inline mb-3">
                            <div class="form-group mb-2">
                                <label for="searchFor" class="mr-2">Искать по</label>
                                <select name="searchFor" id="searchFor" class="form-control">
                                    <option value="id">ID</option>
                                    <option value="text_id">Text ID</option>
                                    <option value="name">Name</option>
                                    <option value="email">Email</option>
                                </select>
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="searchValue" class="mr-2">Значение</label>
                                <input type="text" class="form-control" name="searchValue" id="searchValue"
                                       placeholder="Поиск">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Искать</button>
                            @isset($backButton)
                                <a href="{{ route('admin.users') }}" class="btn btn-primary mb-2 ml-2">Назад</a>
                            @endisset
                        </form>

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
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                        id="drop-{{ $user->id }}" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false"></button>
                                                <div class="dropdown-menu" aria-labelledby="drop-{{ $user->id }}">
                                                    <a class="dropdown-item"
                                                       href="{{ route('admin.users.edit', ['id' => $user->id]) }}">Редактировать</a>

                                                    <a class="dropdown-item"
                                                       href="{{ route('admin.users.delete', ['id' => $user->id]) }}"
                                                       onclick="event.preventDefault();
                                                               document.getElementById('delete-user-{{ $user->id }}').submit();">Удалить</a>

                                                    <form id="delete-user-{{ $user->id }}"
                                                          action="{{ route('admin.users.delete', ['id' => $user->id]) }}"
                                                          method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
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
