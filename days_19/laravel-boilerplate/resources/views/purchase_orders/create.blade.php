@php
    $roles = auth()->user()->roles->pluck('name'); // Get the collection of role names
    $layout = $roles->contains('administrator') ? 'admin.layouts.admin' : 'user.layouts.user';
@endphp

@extends($layout)

@section('title', __('Create Purchase Orders'))

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
        {{ Form::open(['route' => 'purchase_orders.create', 'method' => 'post', 'class' => 'form-horizontal form-label-left']) }}

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="supplier_id">
                Supplier:
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="supplier_id" class="form-control @if($errors->has('supplier_id')) parsley-error @endif" required>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('supplier_id'))
                    <ul class="parsley-errors-list filled">
                        @foreach($errors->get('supplier_id') as $error)
                            <li class="parsley-required">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="order_date">
                Order Date:
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="date" name="order_date" class="form-control @if($errors->has('order_date')) parsley-error @endif" required>
                @if($errors->has('order_date'))
                    <ul class="parsley-errors-list filled">
                        @foreach($errors->get('order_date') as $error)
                            <li class="parsley-required">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="products">
                Products:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div id="products">
                    <div>
                        <select name="products[0][product_id]" class="form-control" required>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                        <input type="number" name="products[0][quantity]" placeholder="Quantity" class="form-control" required>
                    </div>
                </div>
                <button type="button" class="btn btn-info" onclick="addProduct()">Add Product</button>
            </div>
        </div>        

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a class="btn btn-primary" href="{{ route('purchase_orders.index') }}">Cancel</a>
                <button type="submit" class="btn btn-success">Create Purchase Order</button>
            </div>
        </div>

        {{ Form::close() }}
    </div>
</div>

<script>
    let productCount = 1;

    function addProduct() {
        let productDiv = document.getElementById('products');
        let newProduct = `<div>
            <select name="products[${productCount}][product_id]" class="form-control" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
            <input type="number" name="products[${productCount}][quantity]" placeholder="Quantity" class="form-control" required>
        </div>`;
        productDiv.insertAdjacentHTML('beforeend', newProduct);
        productCount++;
    }
</script>
@endsection
