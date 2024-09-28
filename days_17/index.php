<?php
include 'koneksi.php';

session_start();
$message = '';

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <title>Data Pasien</title>

    <style>
        @media (max-width: 768px) {
            h2 {
                font-size: 1.5rem;
            }

            table th,
            table td {
                font-size: 0.9rem;
            }

            .btn {
                font-size: 0.8rem;
            }

            .hapus {
                margin-top: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center m-3">CRUD Data Pasien</h2>
        <a href="tambah.php" class="btn btn-primary p-2 mt-2 mb-2"> Tambah Data Pasien</a>
        <?php if ($message): ?>
            <div class="alert alert-success" role="alert">
                <?= $message ?>
            </div>
        <?php endif; ?>
        <table class="table table-bordered table-striped table-hover align-center align-middle">
            <thead class="thead-light table-dark">
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama</th>
                    <th>alamat</th>
                    <th>umur</th>
                    <th>jenis kelamin</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                include 'koneksi.php';
                $no = 1;
                $data = mysqli_query($koneksi, 'SELECT * FROM m_pasien');
                while ($d = mysqli_fetch_array($data)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $d['nama'] ?></td>
                        <td><?= $d['alamat'] ?></td>
                        <td><?= $d['umur'] ?></td>
                        <td><?= $d['jenis_kelamin'] ?></td>
                        <td class="text-center">
                            <a href="edit.php?id=<?= $d['id'] ?>" class="edit btn btn-warning">EDIT</a>
                            <a href="hapus.php?id=<?= $d['id'] ?>" class="hapus btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data pasien ini?');">DELETE</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>
    <script src=" ./js/bootstrap.bundle.min.js"></script>
</body>

</html>