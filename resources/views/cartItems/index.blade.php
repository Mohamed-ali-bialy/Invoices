
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                    {{ $errors->first('error') }}
                    </div>
                    @endif
                    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if (session('success'))
                    <div id="success-message" class="alert alert-success">
                    {{ session('success') }}
                    </div>
                    @endif

                    <h4 class="mt-4">Cart Table 

                        @foreach ($products as $product )
                        <form action="{{ route('addToCart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="productId" value="{{ $product->id }}">
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1">
                            <button type="submit">Add to Cart</button>
                        </form>
                        @endforeach





                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    // Wait until the page is fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        // Select the success message element
        var successMessage = document.getElementById('success-message');

        // Check if the success message element exists
        if (successMessage) {
            // Show the success message as a popup
            successMessage.style.display = 'block';

            // Automatically hide the success message after  seconds
            setTimeout(function () {
                successMessage.style.display = 'none';
            }, 2000); //  milliseconds 
        }
    });
</script>
