@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            @include('admin.admin_nav')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Информация о платеже</div>

                    <div class="card-body">
                        <p class="card-text">ID: {{ $paymentScore->id }}</p>
                        <p class="card-text">Создан: {{ $paymentScore->created_at }}</p>

                        @if($paymentScore->user)
                            <div class="card">
                                <div class="card-header">Пользователь</div>
                                <div class="card-body">
                                    <p class="card-text">ID: {{ $paymentScore->user->id }}</p>
                                    <p class="card-text">Text ID: {{ $paymentScore->user->text_id }}</p>
                                    <p class="card-text">Имя: {{ $paymentScore->user->name }}</p>
                                    <p class="card-text">E-Mail: {{ $paymentScore->user->email }}</p>
                                    <p class="card-text">Язык: {{ $paymentScore->user->locale }}</p>
                                    <p class="card-text">Создан: {{ $paymentScore->user->created_at }}</p>
                                </div>
                            </div>
                        @endif

                        @if($paymentScore->access)
                            <div class="card mt-3">
                                <div class="card-header">Подписка</div>
                                <div class="card-body">
                                    <p class="card-text">ID: {{ $paymentScore->access->id }}</p>
                                    <p class="card-text">Имя: {{ $paymentScore->access->name }}</p>
                                    <p class="card-text">Имя для
                                        пользователей: {{ $paymentScore->access->name_humanity }}</p>
                                    <p class="card-text">Продолжительность: {{ $paymentScore->access->duration }}</p>
                                    <p class="card-text">Продолжительность для
                                        пользователей: {{ $paymentScore->access->duration_humanity }}</p>
                                    <p class="card-text">Описание: {{ $paymentScore->access->description }}</p>
                                    <p class="card-text">Цена: {{ $paymentScore->access->price / 100 }} $</p>
                                    <p class="card-text">Создан: {{ $paymentScore->access->created_at }}</p>
                                </div>
                            </div>
                        @endif

                        @if($paymentScore->payment)
                            <div class="card mt-3">
                                <div class="card-header">Платеж</div>
                                <div class="card-body">
                                    <p class="card-text">ID: {{ $paymentScore->payment->id }}</p>
                                    <p class="card-text">Статус: {{ $paymentScore->payment->status }}</p>
                                    <p class="card-text">Применен скидочный код: {{ $paymentScore->payment->discount_id ? 'Да' : 'Нет' }}</p>
                                    <p class="card-text">Подписка создана: {{ $paymentScore->payment->user_access_id ? 'Да ID: ' . $paymentScore->payment->user_access_id : 'Нет' }}</p>
                                    <p class="card-text">Цена: {{ $paymentScore->payment->price / 100 }} $</p>
                                    <p class="card-text">Создан: {{ $paymentScore->payment->created_at }}</p>
                                </div>
                            </div>
                        @endif

                        @if($paymentScore->payment && $paymentScore->payment->discount)
                            <div class="card mt-3">
                                <div class="card-header">Скидочный код</div>
                                <div class="card-body">
                                    <p class="card-text">ID: {{ $paymentScore->payment->discount->id }}</p>
                                    <p class="card-text">Имя: {{ $paymentScore->payment->discount->name }}</p>
                                    <p class="card-text">Код: {{ $paymentScore->payment->discount->code }}</p>
                                    <p class="card-text">Описание: {{ $paymentScore->payment->discount->description }}</p>
                                    <p class="card-text">Процент: {{ $paymentScore->payment->discount->percent / 100 }}</p>
                                    <p class="card-text">Создан: {{ $paymentScore->payment->discount->created_at }}</p>
                                </div>
                            </div>
                        @endif

                        @if($paymentScore->payment && $paymentScore->payment->provider)
                            <div class="card mt-3">
                                <div class="card-header">Провайдер платежа</div>
                                <div class="card-body">
                                    <p class="card-text">ID: {{ $paymentScore->payment->provider->id }}</p>
                                    <p class="card-text">Имя: {{ $paymentScore->payment->provider->name }}</p>
                                    <p class="card-text">Service name: {{ $paymentScore->payment->provider->service_name }}</p>
                                    <p class="card-text">Service name slug: {{ $paymentScore->payment->provider->service_name_slug }}</p>
                                    <p class="card-text">Изображение: {{ $paymentScore->payment->provider->image }}</p>
                                    <p class="card-text">Описание: {{ $paymentScore->payment->provider->description }}</p>
                                    <p class="card-text">Data: {{ $paymentScore->payment->provider->data }}</p>
                                    <p class="card-text">Создан: {{ $paymentScore->payment->provider->created_at }}</p>
                                </div>
                            </div>
                        @endif

                        @if($paymentScore->payment)
                            <div class="card mt-3">
                                <div class="card-header">Статусы платежа</div>
                                <div class="card-body">
                                    @foreach($paymentScore->payment->statuses as $paymentStatus)
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="card-text">Статус: {{ $paymentStatus->status }}</p>
                                                <p class="card-text">Data: {{ $paymentStatus->data }}</p>
                                                <p class="card-text">Комментарий: {{ $paymentStatus->comment }}</p>
                                                <p class="card-text">Создан: {{ $paymentStatus->created_at }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
