<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Daftar Post</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .back-arrow {
            font-size: 1.5rem; 
            color: #007bff; 
            position: absolute; 
            top: 15px;
            left: 15px;
            z-index: 1000
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            position: relative;
        }
        h1 {
            color: #343a40;
        }
        .card {
            transition: transform 0.2s;
            margin-bottom: 20px; /* Jarak antar card */
        }
        .card:hover {
            transform: scale(1.02);
        }
        .alert {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <a href="{{ route('home') }}" class="back-arrow">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Blog</h1>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="d-flex justify-content-between mb-4">
            @if(auth()->check() && auth()->user()->roles->pluck('name')->contains('administrator')) 
                <a href="{{ route('posts.create') }}" class="btn btn-success">Tambah</a>
            @endif

            <form class="d-flex" method="GET" action="{{ route('posts.index') }}">
                <input class="form-control me-2" type="search" name="search" placeholder="Cari" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Cari</button>
            </form>
        </div>

        @if($posts->isEmpty())
        <div class="alert alert-info" role="alert">
            Belum ada postingan.
        </div>
        @else
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Kategori: {{ $post->category->name }}</h6>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($post->content, 100, '...') }}</p>
                                <p class="card-text"><small class="text-muted">Diposting pada {{ $post->created_at->format('d M Y') }} oleh Admin</small></p>
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">Baca Selengkapnya</a>
        
                                @if(auth()->check() && auth()->user()->roles->pluck('name')->contains('administrator'))
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus post ini?');">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif    
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
