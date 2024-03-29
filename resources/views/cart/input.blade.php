<form id="cartForm" action="{{ route('cart.store') }}" method="POST">
    @csrf
    <div>
        <label for="product_id">Product ID:</label>
        <input type="text" id="product_id" name="product_id" value="{{ $productId }}" readonly>
    </div>
    <div>
        <label for="quantity">Quantity:</label>
        <input type="text" id="quantity" name="quantity" value="1" readonly> <!-- Automatically set quantity to 1 -->
    </div>
    <div>
        <label for="customer_id">Customer ID:</label>
        <input type="text" id="customer_id" name="customer_id" value="{{ $customerId }}" readonly>
    </div>

    <button type="submit" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">Add to Cart</button>
</form>

<script>
    document.getElementById('cartForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        // Extract the values from the form fields
        var productId = document.getElementById('product_id').value;
        var quantity = document.getElementById('quantity').value;
        var customerId = document.getElementById('customer_id').value;

        // Display the values in an alert
        alert('Product ID: ' + productId + '\nQuantity: ' + quantity + '\nCustomer ID: ' + customerId);

        // Submit the form
        this.submit();
    });
</script>
