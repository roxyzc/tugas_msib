@php
    $roles = auth()->user()->roles->pluck('name'); // Get the collection of role names
    $layout = $roles->contains('administrator') ? 'admin.layouts.admin' : 'user.layouts.user';
@endphp

@extends($layout)

@section('title', 'Product Histories')

@section('content')
<div class="row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th> 
                    <th>Quantity</th>
                    <th>Action</th>
                    <th>Date</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($productHistories as $history)
                <tr>
                    <td>{{ $history->product->sku ?? 'N/A' }}</td>
                    <td>{{ $history->product->name ?? 'N/A' }}</td>
                    <td>{{ $history->quantity }}</td>
                    <td>{{ $history->action }}</td>
                    <td>{{ $history->created_at }}</td> 
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
