@extends('layouts.user')

@section('title', 'Cart')

@section('contents')
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Yoga Studio Template">
    <meta name="keywords" content="Yoga, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title> 

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
</head>
<style>
    .th {
        color: #B99470;
    }
</style>
<body>
<div class="container">
    <h2 class="text-center mb-5" style="color: #5F6F52;">CART ITEMS</h2>
    <div>
        <!-- <p>Customer ID: {{ auth()->user()->customer->customer_id }}</p> -->
        @if ($cartItems->isEmpty())
            <p>Your cart is empty.</p>
        @else
        <div class="cart-page">
        <div class="container">
            <div class="cart-table">
                <table>
                    <thead>
                        <tr>
                        <th></th>
                        <th>Product Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        </tr>
                    </thead>
                <tbody>
                    @foreach ($cartItems as $cartItem)
                        <tr>
                            <td>
                                <input type="checkbox" class="itemCheckbox" data-unit-price="{{ $cartItem->unit_price }}" data-cart-id="{{ $cartItem->product_id }}">

                            </td>
                            <td> @php
                                $images = explode(',', $cartItem->product->images);
                                @endphp
                                @foreach ($images as $image)
                                <img src="/productImages/{{ $image }}" width="100px" style="margin-right: 10px;">
                                @endforeach</td>
                            <td>{{ $cartItem->name }}</td>
                            <td>{{ $cartItem->unit_price }}</td>
                            <td class="quantity-col" width="15px">
                            <div class="pro-qty">
                                <input type="number" class="quantityInput" value="{{ $cartItem->quantity }}" min="1" max="9999" data-cart-id="{{ $cartItem->id }}">
                            </td>
                            </div>
                            <td class="totalPrice">{{ $cartItem->unit_price * $cartItem->quantity }}</td> <!-- Initially display the total price -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <p class="mt-5">Grand Total: <span id="grandTotal">0.00</span></p>
            </div>
            <button onclick="checkout()" class="primary-btn chechout-btn text-white bg-success">Checkout</button> <!-- Checkout button -->
            <!-- Add the button for deleting checked items -->
            <button onclick="deleteSelectedItems()" class="primary-btn chechout-btn text-white bg-danger">Delete Selected</button>

        @endif
    </div>
</div>

<script>
    // Attach event listeners to quantity inputs and checkboxes
    document.querySelectorAll('.quantityInput, .itemCheckbox, pro-qty .qty-btn').forEach(function(element) {
        element.addEventListener('change', updateTotals);
    });

    // Function to update total prices and grand total dynamically
    function updateTotals() {
        var tableRows = document.querySelectorAll('.cart-table tbody tr');
        var grandTotal = 0;
        tableRows.forEach(function(row) {
            var quantity = row.querySelector('.quantityInput').value;
            var unitPrice = row.querySelector('.itemCheckbox').getAttribute('data-unit-price');
            var total = quantity * unitPrice;
            row.querySelector('.totalPrice').textContent = total.toFixed(2);
            if (row.querySelector('.itemCheckbox').checked) {
                grandTotal += total;
            }
        });
        document.getElementById('grandTotal').textContent = grandTotal.toFixed(2);
    }

    // Function to handle the checkout process
    function checkout() {
        var cartItems = [];
        document.querySelectorAll('.itemCheckbox:checked').forEach(function(item) {
            cartItems.push({
                product_id: item.getAttribute('data-cart-id'),
                quantity: item.closest('tr').querySelector('.quantityInput').value
            });
        });

        // Send a POST request to the checkout route with cart items data
        fetch('{{ route('checkout') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ cartItems: cartItems })
        })
        .then(response => {
            if (response.ok) {
                // Handle successful response
                alert('Checkout successful!');
                // Optionally, redirect to another page
                window.location.href = '/cart/display';
            } else {
                // Handle error response
            response.text().then(errorMessage => {
                alert('Checkout failed: ' + errorMessage);
            })
            }
        })
        .catch(error => {
            console.error('Error:', error); 
            alert('An error occurred. Please try again later.');
        });
    }

    function deleteSelectedItems() {
    var checkedItems = document.querySelectorAll('.itemCheckbox:checked');
    if (checkedItems.length === 0) {
        alert('Please select items to delete.');
        return;
    }
    if (confirm('Are you sure you want to delete the selected items?')) {
        checkedItems.forEach(function(item) {
            // Remove the row from the table
            item.closest('tr').remove();
            // Send a POST request to delete the item from the database
            deleteCartItem(item.getAttribute('data-cart-id'));
        });
        updateTotals(); // Update totals after deletion
    }
}

// Function to send a POST request to delete a cart item from the database
function deleteCartItem(productId) {
    alert('Deleting product with ID: ' + productId);
    fetch('/cart/delete/' + productId, { // Assuming the route accepts the product ID
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to delete item.');
        } else {
            // Optionally, update the cart display after successful deletion
            // Implement the logic to update the cart display here
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while deleting the item.');

        response.text().then(errorMessage => {
                alert('Checkout failed: ' + errorMessage);
        })
    });
}

</script>
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/jquery.slicknav.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('js/mixitup.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
@endsection