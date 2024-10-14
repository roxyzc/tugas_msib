<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$data_penduduk = [];

if (file_exists('data_penduduk.json')) {
    $data_penduduk = json_decode(file_get_contents('data_penduduk.json'), true);
}

if (isset($_POST['submit'])) {
    $nama = ucwords($_POST['nama']);
    $usia = $_POST['usia'];
    $alamat = ucwords($_POST['alamat']);
    $pekerjaan = ucwords($_POST['pekerjaan']);

    $data_penduduk[] = [
        'nama' => $nama,
        'usia' => $usia,
        'alamat' => $alamat,
        'pekerjaan' => $pekerjaan,
    ];

    file_put_contents('data_penduduk.json', json_encode($data_penduduk));

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'Nama');
    $sheet->setCellValue('B1', 'Usia');
    $sheet->setCellValue('C1', 'Alamat');
    $sheet->setCellValue('D1', 'Pekerjaan');

    foreach ($data_penduduk as $index => $penduduk) {
        $sheet->setCellValue('A' . ($index + 2), $penduduk['nama']);
        $sheet->setCellValue('B' . ($index + 2), $penduduk['usia']);
        $sheet->setCellValue('C' . ($index + 2), $penduduk['alamat']);
        $sheet->setCellValue('D' . ($index + 2), $penduduk['pekerjaan']);
    }

    $writer = new Csv($spreadsheet);
    $writer->save('data_penduduk.csv');
}

$search_result = [];

if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
    foreach ($data_penduduk as $penduduk) {
        if (stripos($penduduk['nama'], $search_query) !== false) {
            $search_result[] = $penduduk;
        }
    }
} else {
    $search_result = $data_penduduk;
}

if (isset($_POST['export'])) {
    $format = $_POST['format'];
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'Nama');
    $sheet->setCellValue('B1', 'Usia');
    $sheet->setCellValue('C1', 'Alamat');
    $sheet->setCellValue('D1', 'Pekerjaan');

    foreach ($data_penduduk as $index => $penduduk) {
        $sheet->setCellValue('A' . ($index + 2), $penduduk['nama']);
        $sheet->setCellValue('B' . ($index + 2), $penduduk['usia']);
        $sheet->setCellValue('C' . ($index + 2), $penduduk['alamat']);
        $sheet->setCellValue('D' . ($index + 2), $penduduk['pekerjaan']);
    }

    if ($format === 'xlsx') {
        $writer = new Xlsx($spreadsheet);
        $filename = 'data_penduduk.xlsx';
    } else {
        $writer = new Csv($spreadsheet);
        $filename = 'data_penduduk.xls';
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $writer->save('php://output');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penduduk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Data Penduduk</h2>
        <form method="post" class="mb-4 border p-4 rounded" style="margin: auto;">
            <div class="form-group mb-2">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" name="nama" required>
            </div>
            <div class="form-group mb-2">
                <label for="usia">Usia:</label>
                <input type="number" class="form-control" name="usia" required>
            </div>
            <div class="form-group mb-2">
                <label for="alamat">Alamat:</label>
                <input type="text" class="form-control" name="alamat" required>
            </div>
            <div class="form-group mb-2">
                <label for="pekerjaan">Pekerjaan:</label>
                <input type="text" class="form-control" name="pekerjaan" required>
            </div>
            <div class="form-group mb-2">
                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>

        <h2 class="mb-4 mt-5 text-center">Data Penduduk</h2>

        <div class="row mb-4">
            <div class="col-md-6">
                <form method="post" class="form-inline">
                    <div class="form-group mr-2 mb-2">
                        <input type="text" class="form-control" name="search_query" placeholder="Cari berdasarkan nama">
                    </div>
                    <button type="submit" name="search" class="btn btn-secondary">Cari</button>
                </form>
            </div>

            <div class="col-md-6">
                <form method="post" class="form-inline">
                    <div class="form-group mr-2 mb-2">
                        <select name="format" class="form-control" required>
                            <option value="xlsx">XLSX</option>
                            <option value="xls">XLS</option>
                        </select>
                    </div>
                    <button type="submit" name="export" class="btn btn-success">Ekspor</button>
                </form>
            </div>
        </div>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Nama</th>
                    <th>Usia</th>
                    <th>Alamat</th>
                    <th>Pekerjaan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($data_penduduk) && count($search_result)) { ?>
                    <?php foreach ($search_result as $penduduk): ?>
                        <tr>
                            <td><?= $penduduk['nama'] ?></td>
                            <td><?= $penduduk['usia'] ?></td>
                            <td><?= $penduduk['alamat'] ?></td>
                            <td><?= $penduduk['pekerjaan'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php } else if (count($data_penduduk) && !count($search_result)) { ?>
                    <tr>
                        <td colspan="4" class="text-danger text-center">Data yang dicari tidak ada</td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td colspan="4" class="text-danger text-center">Belum ada datanya</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2 class="mb-4 mt-5 text-center">Grafik</h2>
        <div class="mb-4">
            <canvas id="pendudukChart" width="400" height="200"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('pendudukChart');
        const data_pekerjaan = <?= json_encode(array_column($data_penduduk, 'pekerjaan')); ?>;

        const counts = {};
        data_pekerjaan.forEach(p => {
            counts[p] = counts[p] ? counts[p] + 1 : 1;
            console.log(p);
        });

        const pekerjaan = Object.keys(counts);
        const data = Object.values(counts);

        if (data.length) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: pekerjaan,
                    datasets: [{
                        label: 'Pekerjaan Penduduk',
                        data: data,
                        borderWidth: 1,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        } else {
            ctx.parentNode.innerHTML = '<p class="alert alert-danger text-center">Belum ada datanya</p>';
        }
    </script>
</body>

</html>