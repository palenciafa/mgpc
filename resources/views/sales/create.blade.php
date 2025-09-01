@extends('layouts.app')

@section('content')
<h1>New Sale</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<form action="{{ route('sales.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Product</label>
        <select id="product" name="product_id" class="form-control" required>
            <option value="">Select product</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}" 
                        data-stock="{{ $product->stock }}" 
                        data-price="{{ $product->price }}">
                    {{ $product->name }} (Stock: {{ $product->stock }}, Price: ₱{{ number_format($product->price,2) }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Quantity</label>
        <input type="number" id="quantity" name="quantity" min="1" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Total Price</label>
        <input type="text" id="total_price_display" class="form-control" readonly>
        <input type="hidden" id="total_price" name="total_price">
    </div>

    <button class="btn btn-primary">Record Sale</button>
    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const productSelect = document.getElementById('product');
    const quantityInput = document.getElementById('quantity');
    const totalPriceInput = document.getElementById('total_price');
    const totalPriceDisplay = document.getElementById('total_price_display');

    function calculateTotal() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const qty = parseInt(quantityInput.value) || 0;
        const total = price * qty;

        totalPriceDisplay.value = total > 0 ? `₱${total.toFixed(2)}` : '';
        totalPriceInput.value = total.toFixed(2);
    }

    productSelect.addEventListener('change', calculateTotal);
    quantityInput.addEventListener('input', calculateTotal);
});
</script>
@endsection
