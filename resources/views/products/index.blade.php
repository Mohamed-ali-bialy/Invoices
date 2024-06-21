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

            
                        <h4 class="mt-4">Products Listing </h4>
                        
                    
                        @if ($products->count() > 0)
                            <table  class="table custom-table">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Product Name</th>
                                        <th>price</th>
                                        <th>discount</th>
                                        <th>status</th>
                                        <th>category</th>
                                        <th>manufacturer</th>
                                        <th>Add To Cart</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->discount }}</td>
                                            <td>{{ $product->status }}</td>
                                            <td>{{ optional($product->category)->name ?? 'No Category' }}</td>
                                            <td>{{ optional($product->manufacturer)->name ?? 'No Manufacturer' }}</td>    
                                
                                        
                                            <td>
                                                <form id="add-to-cart-form-{{ $product->id }}" action="{{ route('addToCart') }}" method="POST" class="add-to-cart-form">
                                                    @csrf
                                                    <input type="hidden" name="productIds[]" value="{{ $product->id }}">
                                                    <label for="quantity">Quantity:</label>
                                                    <input type="number" name="quantitys[]" id="quantity" value="1" min="1">
                                                    <input type="hidden" name="redirectToCart" value="false">
                                                    <button type="submit" class="add-to-cart-btn" data-product-id="{{ $product->id }}">Add to Cart</button>
                                                    <div class="loading-spinner" style="display: none;"></div>
                                                    <div class="success-message" style="display: none;">Product added to cart!</div>
                                                    <div class="error-message" style="display: none;">An error occurred. Please try again .</div>
                                                </form>
                                            </td>
                                        
                                            
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

        document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.add-to-cart-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(form);
            var addButton = form.querySelector('.add-to-cart-btn');
            var loadingSpinner = form.querySelector('.loading-spinner');
            var successMessage = form.querySelector('.success-message');
            var errorMessage = form.querySelector('.error-message');

            // Disable the button and show loading spinner
            addButton.disabled = true;
            loadingSpinner.style.display = 'block';

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    // Product was added successfully, show success message
                    successMessage.style.display = 'block';
                    setTimeout(function () {
                        successMessage.style.display = 'none';
                    }, 2000);
                } else {
                    // Product was not added, check for error message in response
        response.json().then(data => {
            errorMessage.textContent = data.error || 'An error occurred. Please try again later.';
            errorMessage.style.display = 'block';
            setTimeout(function () {
                errorMessage.style.display = 'none';
            }, 2000);
        });
                }
            })
            .catch(error => {
                // Show error message if there's a network error
                errorMessage.style.display = 'block';
            })
            .finally(() => {
                // Hide loading spinner
                loadingSpinner.style.display = 'none';
                // Re-enable the button after processing
                addButton.disabled = false;
            });
        });
    });
});
</script>

    
