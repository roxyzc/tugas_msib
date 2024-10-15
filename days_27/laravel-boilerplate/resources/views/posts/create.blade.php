<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Buat Post Baru</title>
    <style>
        body {
            background-color: #f2f2f2; /* Latar belakang abu-abu muda */
        }
        .container {
            background-color: white; /* Latar belakang putih untuk kontainer */
            padding: 30px; /* Padding untuk kontainer */
            border-radius: 10px; /* Sudut membulat */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Efek bayangan */
            max-width: 600px; /* Lebar maksimum kontainer */
            margin: auto; /* Pusatkan kontainer */
        }
        h1 {
            color: #343a40; /* Warna judul */
        }
        .btn-primary {
            transition: background-color 0.3s ease; /* Transisi untuk efek hover */
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Warna lebih gelap saat hover */
        }
        .form-label {
            font-weight: bold; /* Cetak tebal untuk label */
        }
        .alert {
            margin-bottom: 20px; /* Spasi di bawah alert */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Buat Post Baru</h1>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('posts.store') }}">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Konten</label>
                <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
