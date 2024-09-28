<?php
include 'Buku.php';
include 'Perpustakaan.php';

session_start();
$message = "";

function checkTahunTerbit($tahunTerbit)
{
    if ($tahunTerbit < 0 || $tahunTerbit > 2024) {
        $_SESSION['message'] = "Tahun terbit isi yang bener";
        return false;
    }
    return true;
}

if (!isset($_SESSION['perpustakaan'])) {
    $_SESSION['perpustakaan'] = new Perpustakaan("Perpustakaan Pusat");
}

if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $tahunTerbit = $_POST['tahunTerbit'];
    $genre = $_POST['genre'];
    $gambar = "";

    if (!checkTahunTerbit($tahunTerbit)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_FILES['uploadFile'])) {
        $fileTmpPath = $_FILES['uploadFile']['tmp_name'];
        $fileName = $_FILES['uploadFile']['name'];
        $fileSize = $_FILES['uploadFile']['size'];
        $fileType = $_FILES['uploadFile']['type'];
        $fileNameCmps = explode('.', $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $allowedfileExtensions = array('jpg', 'png');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = "C:/xampp/htdocs/msib/tugas_days_16/image/";
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $gambar = $dest_path;
            } else {
                $message = 'Upload Gagal';
            }
        } else {
            $message = 'Upload gagal' . implode('.', $allowedfileExtensions);
        }
    } else {
        $message = 'Error ketika upload';
    }


    if ($message === "") {
        $bukuBaru = new Buku($judul, $pengarang, $tahunTerbit, $genre, $gambar);
        $_SESSION['perpustakaan']->tambahBuku($bukuBaru);

        $message = "Buku berhasil ditambahkan!";
        $_SESSION['message'] = $message;
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['message'] = $message;
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css//bootstrap.min.css">
    <title>Tambah buku</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Tambah buku</h1>
        <div class="form">
            <form method="POST" class="border rounded shadow-sm p-5" enctype="multipart/form-data">
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_SESSION['message']; ?>
                    </div>
                    <?php unset($_SESSION['message']);
                    ?>
                <?php endif; ?>

                <div class="form-group pb-4">
                    <label for="judul">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul buku" required>
                </div>
                <div class="form-group pb-4">
                    <label for="pengarang">Pengarang</label>
                    <input type="text" class="form-control" id="pengarang" name="pengarang" placeholder="Masukkan pengarang buku" required>
                </div>
                <div class="form-group pb-4">
                    <label for="tahunTerbit">Tahun Terbit</label>
                    <input type="number" class="form-control" id="tahunTerbit" name="tahunTerbit" placeholder="Masukkan tahun terbut" required>
                </div>
                <div class="form-group pb-4">
                    <label for="genre">Genre</label>
                    <select class="form-control" id="genre" name="genre" required>
                        <option value="fiksi">Fiksi</option>
                        <option value="non-fiksi">Non-Fiksi</option>
                        <option value="romance">Romance</option>
                        <option value="fantasy">Fantasy</option>
                        <option value="action">Action</option>
                        <option value="science">Science</option>
                    </select>
                </div>
                <div class="form-group pb-4">
                    <label for="uploadFile">Unggah Gambar</label>
                    <input type="file" class="form-control" id="uploadFile" name="uploadFile" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 pb-2" name="submit">Submit</button>
            </form>
            <a href="index.php">Kembali ke Daftar Buku</a>
        </div>
    </div>

    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>