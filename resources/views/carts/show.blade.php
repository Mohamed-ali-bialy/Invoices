@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div id="popup-container"></div>

                <div class="card-header">{{ __('Cart Items') }}</div>

                <div class="card-body">
                    @if (!$transformedItems->isEmpty())

                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Clear Cart</button>
                    </form>

                    <form class="additem" id="AddToCart" name="add" action="{{ route('addToCart') }}" method="POST">
                        @csrf
                        <table id="cart-items-table" class="table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                    <th>Total</th>
                                    <th>Quantity</th> 
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transformedItems as $cartItem)
                                
                                <tr>
                                    <td  id="product_name">{{ $cartItem['product_name'] }}</td>
                                    <td>{{ $cartItem['price'] }}</td>
                                    <td>{{  $cartItem['subtotal']}}</td>
                                    <td>{{ $cartItem['total'] }}</td>
                                    <td>
                                        <input type="hidden" name="productIds[]" value="{{ $cartItem['product_id'] }}">
                                        <input type="hidden" name="cartItemIds[]" value="{{ $cartItem['id'] }}">
                                        <div class="quantity-input">
                                            <button class="quantity-btn minus-btn">-</button>
                                            <input type="number" name="quantitys[]" id="quantity" value="{{ $cartItem['quantity'] }}" >
                                            <button class="quantity-btn plus-btn">+</button>
                                        </div>
                                    </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.delete', $cartItem['id']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            <button class="-btn" type="submit" form="AddToCart" value="Update">Order Summary</button>
                        </div>
                    
                    @else
                    <p>Your cart is empty.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Order Summary') }}</div>

                <div class="card-body">
                    @if ($transformedItems->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>SubTotal</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="subtotal"  >{{$cartItem['cartSubTotal'] }}</td>
                                <td id="net-total" > {{ $cartItem['cartTotal'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>SubTotal</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td >0</td>
                                <td>0</td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.additem');

    form.addEventListener('submit', function(event) {
       
        event.preventDefault(); // Prevent default form submission behavior

        var formData = new FormData(form);

        let hasZeroQuantity = false;
        const quantityInputs = form.querySelectorAll('input[name="quantitys[]"]');

        quantityInputs.forEach(input => {
            if (parseInt(input.value) <= 0) {
                hasZeroQuantity = true;
            }
        });

        if (hasZeroQuantity) {
            // Display error message and prevent AJAX call
            displayPopup('Quantity cannot be less than 1 .', 'error');
            return; // Stop the function execution
        }


        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            // Try to parse JSON regardless of response status
            return response.json().then(jsonData => {
                if (response.ok) {
                    return jsonData;
                } else {
                    // Extract error message from the response JSON
                    throw new Error(jsonData.error || 'Network response was not ok.');
                }
            });
        })
        .then(data => {
            if (data.success && data.cart_items) {
                updateCartItems(data.cart_items);
                updateOrderSummary(data.subtotal, data.net_total);

                var responseMessage = data.message;
                displayPopup(responseMessage); // Show success message
            } else {
                // Handle unexpected data format
                throw new Error('Invalid response format.');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            // Display the extracted error message
            displayPopup(error.message, 'error'); // Show error message
        });

        console.log('Form submitted!');
    });

    form.addEventListener('click', function(event) {
        const target = event.target;

        // Handle minus button click
        if (target.classList.contains('minus-btn')) {
            const quantityInput = target.nextElementSibling;
            const currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        }

        // Handle plus button click
        if (target.classList.contains('plus-btn')) {
            const quantityInput = target.previousElementSibling;
            const currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        }
    });

    function updateCartItems(cartItems) {
        const tableBody = document.querySelector('#cart-items-table tbody');
        
        // Check if cartItems array is not empty
        if (cartItems.length > 0) {
            tableBody.innerHTML = ''; // Clear existing table rows
            
            cartItems.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.product_name}</td>
                    <td>${item.price}</td>
                    <td>${item.subtotal}</td>
                    <td>${item.total}</td>
                    <td>
                        <input type="hidden" name="productIds[]" value="${item.product_id}">
                        <input type="hidden" name="cartItemIds[]" value="${item.id}">
                        <div class="quantity-input">
                            <button class="quantity-btn minus-btn">-</button>
                            <input type="number" name="quantitys[]" value="${item.quantity}">
                            <button class="quantity-btn plus-btn">+</button>
                        </div>
                    </td>
                    <td>
                        <form action="/cart-items/${item.id}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        } else {
            // If cartItems array is empty, display a message or perform any other action
            console.log('Cart is empty.');
        }
    }

    function updateOrderSummary(subtotal, netTotal) {
        document.getElementById('subtotal').textContent = subtotal;
        document.getElementById('net-total').textContent = netTotal;
    }



     //LAZM TB2 BARA EL EVENT LISTNER 
    function displayPopup(message, type = 'info') {
        var popupContainer = document.getElementById('popup-container');
        popupContainer.innerHTML = message;
        popupContainer.style.display = 'block';
        
        if (type === 'error') {
            popupContainer.classList.add('popup-error');
        } else {
            popupContainer.classList.remove('popup-error');
        }

        setTimeout(function() {
            popupContainer.style.display = 'none';
        }, 5000); // Hide after 5 seconds
    }
});





</script>
