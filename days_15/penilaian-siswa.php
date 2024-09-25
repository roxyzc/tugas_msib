<?php
session_start();

$message = '';
$editIndex = null;

function validasiNilai($nilai)
{
    if ($nilai < 0 || $nilai > 100) {
        return false;
    }
    return true;
}

if (!isset($_SESSION['data'])) {
    $_SESSION['data'] = array();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $indexToDelete = $_GET['index'];
    if (isset($_SESSION['data'][$indexToDelete])) {
        unset($_SESSION['data'][$indexToDelete]);
        $_SESSION['data'] = array_values($_SESSION['data']);
    }

    header("Location: penilaian-siswa.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'edit') {
    $editIndex = $_GET['index'];
    $editData = $_SESSION['data'][$editIndex];
}

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $mtk = $_POST['mtk'];
    $ipa = $_POST['ipa'];
    $ips = $_POST['ips'];
    $inggris = $_POST['inggris'];

    $rata_rata = ($mtk + $ipa + $ips + $inggris) / 4;

    if (
        validasiNilai($mtk) &&
        validasiNilai($ipa) &&
        validasiNilai($ips) &&
        validasiNilai($inggris)
    ) {
        $rata_rata = ($mtk + $ipa + $ips + $inggris) / 4;

        if ($editIndex !== null) {
            $_SESSION['data'][$editIndex] = [
                'nama' => $nama,
                'kelas' => $kelas,
                'mtk' => $mtk,
                'ipa' => $ipa,
                'ips' => $ips,
                'inggris' => $inggris,
                'avg' => $rata_rata
            ];
            $message = "Data berhasil diperbarui.";
            header("Location: penilaian-siswa.php");
            exit();
        } else {
            $_SESSION['data'][] = [
                'nama' => $nama,
                'kelas' => $kelas,
                'mtk' => $mtk,
                'ipa' => $ipa,
                'ips' => $ips,
                'inggris' => $inggris,
                'avg' => $rata_rata
            ];
            $message = "Data berhasil ditambahkan.";
        }
    } else {
        $message = "Terdapat kesalahan dalam input nilai. Data tidak disimpan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css//bootstrap.min.css">
    <title>Sistem Penilaian Siswa Sederhana</title>
    <style>
        body {
            font-size: 16px;
            margin: auto;
            max-width: 800px;
        }


        @media (max-width: 576px) {
            body {
                font-size: 12px;
                width: 100%;
            }
        }
    </style>
</head>

<body class="d-flex p-5 justify-content-center">
    <div class="container">
        <form method="POST" class="border rounded shadow-sm p-5">
            <div class="form-group pb-4">
                <label for="nama">Nama Siswa</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama siswa" value="<?= isset($editData) ? $editData['nama'] : '' ?>" required>
            </div>
            <div class="form-group pb-4">
                <label for="kelas">Kelas</label>
                <select class="form-control" id="kelas" name="kelas" required>
                    <option value="6a" <?= isset($editData) && $editData['kelas'] == '6a' ? 'selected' : '' ?>>6A</option>
                    <option value="6b" <?= isset($editData) && $editData['kelas'] == '6b' ? 'selected' : '' ?>>6B</option>
                    <option value="6c" <?= isset($editData) && $editData['kelas'] == '6c' ? 'selected' : '' ?>>6C</option>
                </select>
            </div>
            <div class="form-group pb-4">
                <label for="mtk">Nilai MTK</label>
                <input type="number" class="form-control" id="mtk" name="mtk" placeholder="Masukkan nilai MTK" value="<?= isset($editData) ? $editData['mtk'] : '' ?>" required>
            </div>
            <div class="form-group pb-4">
                <label for="ipa">Nilai IPA</label>
                <input type="number" class="form-control" id="ipa" name="ipa" placeholder="Masukkan nilai IPA" value="<?= isset($editData) ? $editData['ipa'] : '' ?>" required>
            </div>
            <div class="form-group pb-4">
                <label for="ips">Nilai IPS</label>
                <input type="number" class="form-control" id="ips" name="ips" placeholder="Masukkan nilai IPS" value="<?= isset($editData) ? $editData['ips'] : '' ?>" required>
            </div>
            <div class="form-group pb-4">
                <label for="inggris">Nilai Bahasa Inggris</label>
                <input type="number" class="form-control" id="inggris" name="inggris" placeholder="Masukkan nilai Bahasa Inggris" value="<?= isset($editData) ? $editData['inggris'] : '' ?>" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 pb-2" name="submit"><?= isset($editData) ? 'Update' : 'Submit' ?></button>
        </form>
        <p class="text-danger"><?= $message ?></p>

        <?php if (!empty($_SESSION['data'])): ?>
            <table class="table border table-striped shadow-sm rounded w-100">
                <thead class="thead-dark">
                    <tr>
                        <th class="col">No</th>
                        <th class="col">Nama</th>
                        <th class="col">Kelas</th>
                        <th class="col">MTK</th>
                        <th class="col">IPA</th>
                        <th class="col">IPS</th>
                        <th class="col">Bahasa Inggris</th>
                        <th class="col">Rata-rata</th>
                        <th class="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['data'] as $index => $val): ?>
                        <tr class="text-center align-middle">
                            <td><?= $index + 1 ?></td>
                            <td><?= $val['nama'] ?></td>
                            <td><?= $val['kelas'] ?></td>
                            <td><?= $val['mtk'] ?></td>
                            <td><?= $val['ipa'] ?></td>
                            <td><?= $val['ips'] ?></td>
                            <td><?= $val['inggris'] ?></td>
                            <td><?= $val['avg'] ?></td>
                            <td>
                                <a href="?action=edit&index=<?= $index ?>" class="btn btn-primary">Edit</a>
                                <a href="?action=delete&index=<?= $index ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    </div>
    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>