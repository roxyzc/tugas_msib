@php
    $roles = auth()->user()->roles->pluck('name'); 
    $layout = $roles->contains('administrator') ? 'admin.layouts.admin' : 'user.layouts.user';
@endphp

@extends($layout)

@section('title', 'Purchase Orders')

@section('content')
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('purchase_orders.create') }}" class="btn btn-primary">Create New Purchase Order</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Supplier</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseOrders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->supplier->name }}</td>
                    <td>{{ $order->order_date }}</td>
                    <td>{{ number_format($order->total_amount) }}</td>
                    <td>
                        <a href="{{ route('purchase_orders.show', $order->id) }}" class="btn btn-info">View Details</a>
                        <form action="{{ route('purchase_orders.destroy', $order->id) }}" method="POST" style="display:inline;">
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
