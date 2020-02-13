@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Создать маршрут из VPN серверов</div>

                    <div class="card-body">
                        <div id="vpn-path-configure">
                            <vpn-path-configure :servers-prop="'{{ base64_encode(json_encode($servers, JSON_NUMERIC_CHECK)) }}'" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection