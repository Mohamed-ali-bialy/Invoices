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
            <div>
            <a href="{{ route('invoice') }}" class="btn btn-primary mt-3">
                 Invoices
            </a>
            <a ></a>
            <a href="{{ route('productsManagemnet') }}" class="btn btn-primary mt-3">
                Products Management
            </a>
            <a ></a>
           <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
            Products Listing
          </a>
            <a ></a>
            <a href="{{ route('categories.index') }}" class="btn btn-primary mt-3">
                Categories
           </a>
           <a ></a>
           <a href="{{ route('manufacturers.index') }}" class="btn btn-primary mt-3">
            Manufacturers
          </a>
          <a ></a>
           <a href="{{ route('carts.index') }}" class="btn btn-primary mt-3">
            Cart
          </a>
          <a ></a>
          
          
            
        </div>            

        </div>
    </div>
</div>
@endsection
