@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header">{{ __('servers.' . $title) }}</div>

                    <div class="card-body">
                        <div id="servers">
                            <servers-component :servers-prop="{{ json_encode($servers) }}"></servers-component>
                        </div>

                        {{ $servers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
