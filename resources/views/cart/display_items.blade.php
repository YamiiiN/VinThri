@extends('layouts.user')

@section('title', 'Home')

@section('contents')
<div class="container">
    <h1>Cart Items</h1>
    <div>
        <p>Customer ID: {{ auth()->user()->customer->customer_id }}</p>
        @if ($cartItems->isEmpty())
            <p>Your cart is empty.</p>
        @else
            <table class="table" id="cartTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th> <!-- New column for total price -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $cartItem)
                        <tr>
                            <td>
                                <input type="checkbox" class="itemCheckbox" data-unit-price="{{ $cartItem->unit_price }}" data-cart-id="{{ $cartItem->product_id }}">

                            </td>
                            <td>{{ $cartItem->product_id }}</td>
                            <td>{{ $cartItem->name }}</td>
                            <td>{{ $cartItem->unit_price }}</td>
                            <td>
                                <input type="number" class="quantityInput" value="{{ $cartItem->quantity }}" min="1" max="9999" data-cart-id="{{ $cartItem->id }}">
                            </td>
                            <td class="totalPrice">{{ $cartItem->unit_price * $cartItem->quantity }}</td> <!-- Initially display the total price -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <p>Grand Total: <span id="grandTotal">0.00</span></p>
            </div>
            <button onclick="checkout()">Checkout</button> <!-- Checkout button -->
            <!-- Add the button for deleting checked items -->
            <button onclick="deleteSelectedItems()">Delete Selected</button>

        @endif
    </div>
</div>

<script>
    // Attach event listeners to quantity inputs and checkboxes
    document.querySelectorAll('.quantityInput, .itemCheckbox').forEach(function(element) {
        element.addEventListener('change', updateTotals);
    });

    // Function to update total prices and grand total dynamically
    function updateTotals() {
        var tableRows = document.querySelectorAll('#cartTable tbody tr');
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
@endsection