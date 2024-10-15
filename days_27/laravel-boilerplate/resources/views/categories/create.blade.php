@extends('admin.layouts.admin')

@section('title', __('Tambah Kategori'))

@section('content')
    <style>
        body {
            background-color: #f8f9fa; 
        }
        .container-create {
            background-color: white; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); 
            margin-top: 50px; 
        }
        h1 {
            color: #343a40;
        }
        .btn-custom {
            margin-top: 10px;
            background-color: #28a745; 
            color: white; 
        }
        .btn-custom:hover {
            background-color: #218838;
        }
        .btn-secondary {
            margin-top: 10px;
            margin-left: 10px;
        }
    </style>

    <div class="container container-create mt-5">
        <h1 class="mb-4">Tambah Kategori</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama kategori" required>
            </div>
            <button type="submit" class="btn btn-custom">Simpan</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
