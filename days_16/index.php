<?php
include 'Buku.php';
include 'Perpustakaan.php';

session_start();
$message = "";

if (isset($_SESSION['perpustakaan'])) {
    $perpustakaan = $_SESSION['perpustakaan'];
    $daftarBuku = $perpustakaan->getDaftarBuku();
} else {
    $perpustakaan = new Perpustakaan("Perpustakaan Pusat");
    $_SESSION['perpustakaan'] = $perpustakaan;
    $daftarBuku = [];
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku Perpustakaan</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f4;
        }

        h1 {
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Daftar Buku di <?= $perpustakaan->lokasi ?></h1>
        <?php if ($message): ?>
            <?php if ($message == "Tidak ada buku di perpustakaan ini"): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $message ?>
                </div>
            <?php else: ?>
                <div class="alert alert-success" role="alert">
                    <?= $message ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <table class="table table-bordered mt-4 text shadow-sm">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Tahun Terbit</th>
                    <th>Genre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarBuku)): ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada buku yang tersedia di perpustakaan.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarBuku as $index => $buku): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $buku->getBuku()['judul'] ?></td>
                            <td><?= $buku->getBuku()['pengarang'] ?></td>
                            <td><?= $buku->getBuku()['tahunTerbit'] ?></td>
                            <td><?= $buku->getBuku()['genre'] ?></td>
                            <td class="text-center">
                                <a href="detail.php?index=<?= $index; ?>">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="tambahBuku.php" class="btn btn-primary text-light p-2"> Tambah buku</a>
    </div>

    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>