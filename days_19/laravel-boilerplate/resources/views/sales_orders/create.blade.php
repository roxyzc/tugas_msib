@php
    $roles = auth()->user()->roles->pluck('name'); 
    $layout = $roles->contains('administrator') ? 'admin.layouts.admin' : 'user.layouts.user';
@endphp

@extends($layout)

@section('title', __('Create Sales Order'))

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('sales_orders.create') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="customer_id">Customer</label>
            <select name="customer_id" class="form-control" required>
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="order_date">Order Date</label>
            <input type="date" name="order_date" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="products">Products</label>
            <div id="productFields">
                <div class="product-field">
                    <select name="products[0][product_id]" class="form-control" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="products[0][quantity]" class="form-control" placeholder="Quantity" required>
                </div>
            </div>
            <button type="button" id="addProduct" class="btn btn-info mt-2">Add Another Product</button>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
</div>

<script>
    document.getElementById('addProduct').addEventListener('click', function() {
        var productFields = document.getElementById('productFields');
        var newFieldIndex = productFields.children.length;
        var newField = document.createElement('div');
        newField.classList.add('product-field');
        newField.innerHTML = `
            <select name="products[${newFieldIndex}][product_id]" class="form-control" required>
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
            <input type="number" name="products[${newFieldIndex}][quantity]" class="form-control" placeholder="Quantity" required>
        `;
        productFields.appendChild(newField);
    });
</script>
@endsection
