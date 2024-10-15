<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>{{ $post->title }}</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .post-title {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #343a40;
            font-weight: bold;
        }
        .post-category {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 20px;
        }
        .post-content {
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 30px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .post-image {
            width: 100%; 
            height: auto; 
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .action-buttons {
            margin-top: 20px;
        }
        .comment-section {
            margin-top: 30px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .comment {
            margin-bottom: 15px;
            padding: 10px;
            border-left: 4px solid #007bff;
            background-color: #f1f1f1;
            border-radius: 5px;
        }
        .comment-author {
            font-weight: bold;
            color: #007bff;
            display: inline;
            margin-right: 10px;
        }
        .comment-time {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .form-control {
            border: 1px solid #007bff;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #0056b3;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .comment-input {
            margin-top: 20px;
        }

        .post-tags {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .post-tags h6 {
            font-weight: bold;
            color: #343a40;
        }

        .post-tags .badge {
            font-size: 0.9rem;
            margin: 5px 5px 0 0; /* Space between badges */
            transition: background-color 0.3s, transform 0.3s;
        }

        .post-tags .badge:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

</style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="post-title">{{ $post->title }}</h1>
        <h6 class="post-category">Kategori: {{ $post->category->name }}</h6>

        <div class="post-content">
            <img src="https://www.hostinger.co.id/tutorial/wp-content/uploads/sites/11/2019/03/apa-itu-blog-dan-pengertian-blog.webp" alt="Gambar Post" class="post-image">
            <p>{{ $post->content }}</p>
        </div>

        <div class="post-tags">
            <h6>Tags:</h6>
            @if($post->tags->isNotEmpty())
                <div class="d-flex flex-wrap">
                    @foreach($post->tags as $tag)
                        <a href="#" class="badge bg-secondary me-2 mb-2 text-decoration-none">{{ $tag->name }}</a>
                    @endforeach
                </div>
            @else
                <p>Tidak ada tag untuk post ini.</p>
            @endif
        </div>

        <div class="action-buttons d-flex justify-content-between">
            <a href="{{ route('posts.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <div>
                @if(auth()->check() && auth()->user()->roles->pluck('name')->contains('administrator'))
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
        
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

        <div class="comment-section">
            <h4>Komentar ({{ $post->comments->count() }})</h4>
            @foreach($post->comments as $comment)
                <div class="comment">
                    <p class="comment-author">
                        {{ $comment->user->name }} 
                        @if(auth()->check() && (auth()->user()->id === $comment->user_id || auth()->user()->roles->pluck('name')->contains('administrator')))
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link p-0" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');" title="Hapus komentar">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </button>
                            </form>
                        @endif
                    </p>
                    <p class="comment-time">{{ $comment->created_at->format('d M Y H:i') }}</p>
                    <p>{{ $comment->body }}</p>
                </div>
            @endforeach

            @if(auth()->check())
                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="comment-input">
                    @csrf
                    <div class="mb-3">
                        <label for="body" class="form-label">Tambahkan Komentar</label>
                        <textarea class="form-control" id="body" name="body" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                </form>
            @else
                <p>Silakan <a href="{{ route('login') }}">masuk</a> untuk menambahkan komentar.</p>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
