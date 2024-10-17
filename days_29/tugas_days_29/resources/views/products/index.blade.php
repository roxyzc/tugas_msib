@extends('layouts.app')

@section('title', 'List Produk')

@section('content')
<div class="container">
    <h1>Products</h1>
    <a href="{{ route('products.create') }}" class="btn btn-dark text-light ps-3 pe-3 mb-3">Tambah data</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif 
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif 
    <table id="products-table" class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category }}</td>
                <td>{{ 'Rp. ' . number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ $product->created_at }}</td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
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

<script>
$(document).ready(function() {
    $('#products-table').DataTable(
        {
            dom: "Bfrtip",
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
        }
    );
});
</script>
@endsection
