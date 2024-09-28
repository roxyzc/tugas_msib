<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <title>Edit Data Pasien</title>
</head>

<body>
    <div class="container mt-5">

        <div class="p-5 border rounded shadow">
            <h2 class="text-center mb-4">Edit Data Pasien</h2>
            <?php
            if (isset($_SESSION['message'])): ?>
                <div class="alert alert-info" role="alert">
                    <?=
                    $_SESSION['message'];
                    unset($_SESSION['message']);
                    ?>
                </div>
            <?php endif; ?>

            <?php
            include 'koneksi.php';
            $id = $_GET['id'];
            $data = mysqli_query($koneksi, "SELECT * FROM m_pasien WHERE id='$id'");
            while ($d = mysqli_fetch_assoc($data)) {
            ?>
                <form action="edit_aksi.php" method="post">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama" value="<?= $d['nama'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukkan Alamat" rows="3" required><?= $d['alamat'] ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="umur" class="form-label">Umur</label>
                        <input type="number" name="umur" id="umur" class="form-control" placeholder="Masukkan Umur" value="<?= $d['umur'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" <?= $d['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= $d['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>

                    <input type="hidden" name="id" id="id" class="form-control" value="<?= $d['id']  ?>" required>

                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                </form>

            <?php } ?>
        </div>

        <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>