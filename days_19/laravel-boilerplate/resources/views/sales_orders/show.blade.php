@php
    $roles = auth()->user()->roles->pluck('name'); 
    $layout = $roles->contains('administrator') ? 'admin.layouts.admin' : 'user.layouts.user';
@endphp

@extends($layout)

@section('title', __('Sales Order Details'))

@section('content')
<div class="row">
    <div class="col-md-12">
    <p><strong>Order ID:</strong> {{ $salesOrder->id }}</p>
    <p><strong>Customer:</strong> {{ $salesOrder->customer->name }}</p>
    <p><strong>Order Date:</strong> {{ $salesOrder->order_date }}</p>
    <p><strong>Total Amount:</strong> {{ number_format($salesOrder->total_amount, 2) }}</p>

    <h2>Products</h2>
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
            @foreach($salesOrder->details as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->price, 2) }}</td>
                    <td>{{ number_format($detail->quantity * $detail->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('sales_orders.index') }}" class="btn btn-info">Back to Sales Orders</a>
</div>
</div>
@endsection
