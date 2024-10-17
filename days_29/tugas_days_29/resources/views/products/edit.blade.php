@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container">
    <a href="{{ route('products.index') }}" class="btn btn-dark text-light mb-3 ps-3 pe-3">Kembali</a>
    <div class="border rounded p-4 shadow-sm" style="border: 1px solid #ced4da;">
        <h1 class="text-center">Edit Produk</h1>

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group p-2">
                <label for="name">Nama Produk</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-group p-2">
                <label for="category">Kategori</label>
                <input type="text" name="category" class="form-control" id="category" value="{{ old('category', $product->category) }}" required>
            </div>

            <div class="form-group p-2">
                <label for="price">Harga</label>
                <input type="number" name="price" class="form-control" id="price" value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="form-group p-2">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection