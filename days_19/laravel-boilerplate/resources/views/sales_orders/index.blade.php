@php
    $roles = auth()->user()->roles->pluck('name'); 
    $layout = $roles->contains('administrator') ? 'admin.layouts.admin' : 'user.layouts.user';
@endphp

@extends($layout)

@section('title', __('Sales Orders'))

@section('content')
<div class="row">
    <div class="col-md-12">
    <a href="{{ route('sales_orders.create') }}" class="btn btn-primary">Create New Sales Order</a>
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Order Date</th>
                <th>Total Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salesOrders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->order_date }}</td>
                    <td>{{ number_format($order->total_amount, 2) }}</td>
                    <td>
                        <a href="{{ route('sales_orders.show', $order->id) }}" class="btn btn-info">View</a>
                        <form action="{{ route('sales_orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection
