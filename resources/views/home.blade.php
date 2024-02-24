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

                    {{ __('You are logged in!') }}

                    <!-- Add a button to route to the invoice page -->
                   
                </div>
            </div>
            <a href="{{ route('invoice') }}" class="btn btn-primary mt-3">
                View Invoices
            </a>
        </div>
    </div>
</div>
@endsection
