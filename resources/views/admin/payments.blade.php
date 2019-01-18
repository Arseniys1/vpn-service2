@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            @include('admin.admin_nav')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Платежи</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('admin.payments.search') }}" class="form-inline mb-3">
                            <div class="form-group mb-2">
                                <label for="searchFor" class="mr-2">Искать по</label>
                                <select name="searchFor" id="searchFor" class="form-control">
                                    <option value="id">ID</option>
                                    <option value="user_id">User ID</option>
                                    <option value="user_name">User name</option>
                                    <option value="access_id">Access ID</option>
                                    <option value="payment_id">Payment ID</option>
                                </select>
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="searchValue" class="mr-2">Значение</label>
                                <input type="text" class="form-control" name="searchValue" id="searchValue"
                                       placeholder="Поиск">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Искать</button>
                            @isset($backButton)
                                <a href="{{ route('admin.payments') }}" class="btn btn-primary mb-2 ml-2">Назад</a>
                            @endisset
                        </form>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Имя пользователя</th>
                                    <th scope="col">Имя подписки</th>
                                    <th scope="col">ID платежа</th>
                                    <th scope="col">Создан</th>
                                    <th scope="col">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($paymentsScore as $paymentScore)
                                    <tr>
                                        <th scope="row"><a href="{{ route('admin.payments.detail', ['score_id' => $paymentScore->id]) }}">{{ $paymentScore->id }}</a></th>
                                        <td>{{ $paymentScore->user ? $paymentScore->user->name : 'null' }}</td>
                                        <td>{{ $paymentScore->access ? $paymentScore->access->name : 'null' }}</td>
                                        <td>{{ $paymentScore->payment ? $paymentScore->payment->id : 'null' }}</td>
                                        <td>{{ $paymentScore->created_at }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                        id="drop-{{ $paymentScore->id }}" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false"></button>
                                                <div class="dropdown-menu" aria-labelledby="drop-{{ $paymentScore->id }}">
                                                    <a class="dropdown-item"
                                                       href="{{ route('admin.payments.detail', ['score_id' => $paymentScore->id]) }}">Подробнее</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $paymentsScore->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
