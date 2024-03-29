<!-- resources/views/cart/display.blade.php -->

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
                                <input type="checkbox" class="itemCheckbox" data-unit-price="{{ $cartItem->unit_price }}" data-cart-id="{{ $cartItem->id }}">
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
                <button onclick="checkout()">Checkout</button>
            </div>
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
</script>
