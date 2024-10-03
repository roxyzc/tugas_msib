@php
    $roles = auth()->user()->roles->pluck('name'); // Get the collection of role names
    $layout = $roles->contains('administrator') ? 'admin.layouts.admin' : 'user.layouts.user';
@endphp

@extends($layout)

@section('title', 'Purchase Order Detail')

@section('content')
<div class="row">
    <div class="col-md-12">
        <p><strong>Supplier:</strong> {{ $purchaseOrder->supplier->name }}</p>
        <p><strong>Order Date:</strong> {{ $purchaseOrder->order_date }}</p>
        <p><strong>Total Amount:</strong> {{ number_format($purchaseOrder->total_amount, 2) }}</p>

        <h3>Products:</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseOrder->details as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->price, 2) }}</td>
                    <td>{{ number_format($detail->quantity * $detail->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('purchase_orders.index') }}" class="btn btn-primary">Back to Purchase Orders</a>
    </div>
</div>
@endsection
