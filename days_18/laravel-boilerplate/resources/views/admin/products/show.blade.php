@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <h1 class="text-center">{{ $product->name }}</h1>

        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning mb-3">Edit Product</a>
                <a href="{{ route('admin.products') }}" class="btn btn-secondary mb-3">Back to Products</a>
            </div>
        </div>

        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>SKU</th>
                    <td>{{ $product->sku }}</td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>{{ $product->price }}</td>
                </tr>
                <tr>
                    <th>Stock</th>
                    <td>{{ $product->stock }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $product->created_at->format('d M Y H:i') }} ({{ $product->created_at->diffForHumans() }})</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $product->updated_at->format('d M Y H:i') }} ({{ $product->updated_at->diffForHumans() }})</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
