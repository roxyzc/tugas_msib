<?php
include 'Perpustakaan.php';
include 'Buku.php';

session_start();

if (!isset($_SESSION['perpustakaan'])) {
    header("Location: index.php");
    exit();
}

$daftarBuku = $_SESSION['perpustakaan']->getDaftarBuku();

if (isset($_GET['index']) && isset($daftarBuku[$_GET['index']])) {
    $buku = $daftarBuku[$_GET['index']];
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <title>Detail Buku</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Detail Buku</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <img src="image/<?= basename($buku->getBuku()['gambar']); ?>" class="card-img-top" alt="<?= $buku->getBuku()['judul']; ?>" style="max-height: 300px; object-fit: cover;"> <!-- Menjaga ukuran gambar -->
                        <h5 class="card-title"><?= $buku->getBuku()['judul']; ?></h5>
                        <p class="card-text">
                            <?= $buku->getDetailBuku(); ?>
                        </p>
                        <a href="index.php" class="btn btn-primary">Kembali ke Daftar Buku</a>
                        <a href="#" class="btn btn-danger">Hapus Buku</a>
                        <a href="#" class="btn btn-info">Edit Buku</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>