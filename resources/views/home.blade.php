@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="/oauth/connect">Authorize from server</a><br>
                    <a href="/oauth/invoice/create">Create an invoice</a><br>
                    <a href='{{ route('index') }}'>Invoices</a><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
