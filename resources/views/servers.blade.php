@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header">{{ __('servers.' . $title) }}</div>

                    <div class="card-body">
                        <div id="servers">
                            <servers-component :langs-prop="'{{ base64_encode(json_encode($langs)) }}'" :servers-prop="'{{ base64_encode(json_encode($servers, JSON_NUMERIC_CHECK)) }}'"></servers-component>
                        </div>

                        {{ $servers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection