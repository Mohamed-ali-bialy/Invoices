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
                    
                    @if (session('success'))
                    <div id="success-message" class="alert alert-success">
                    {{ session('success') }}
                    </div>
                    @endif

                    <a href="{{ route('products.create') }}" class="btn btn-primary mt-3">
                        Create Product
                   </a>

                   <form action="{{ url('produts/export') }}" method="GET">
                    @csrf
                    <button type="submit">Products Download</button>
                </form>

                <form action="{{ route('import.products') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file">
                    <button type="submit">Import Products</button>
                </form>

                    <h4 class="mt-4">Products Management 
                        
                    </h4>
                    
                
                    @if ($products->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>price</th>
                                    <th>discount</th>
                                    <th>stock</th>
                                    <th>status</th>
                                    <th>Category</th>
                                    <th>Manufacturer</th>
                                    
                                    <!-- Add more columns as needed -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->product_Code }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->discount }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>{{ $product->status }}</td>
                                        <td>{{ optional($product->category)->name ?? 'No Category' }}</td>
                                        <td>{{ optional($product->manufacturer)->name ?? 'No Manufacturer' }}</td>

                                    
                                        <td>
                                            <a href="{{ route('products.show', $product) }}" class="btn btn-primary">View Details</a>

                                        </td>
                                    
                                        <!-- Add more columns as needed -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $products->render('custom_pagination') }}
                       

                    @else
                        <p>You have no products.</p>
                    @endif
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
