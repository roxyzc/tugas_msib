<?php
session_start();

if (!isset($_SESSION['buku'])) {
    $_SESSION['buku'] = [
        "1" => "Buku A",
        "2" => "Buku B",
        "3" => "Buku C",
        "4" => "Buku D",
    ];
}

if (!isset($_SESSION['p_buku'])) {
    $_SESSION['p_buku'] = [];
}

function tampilkanDaftarBuku($buku)
{
    $output = "<h2>Daftar Buku:</h2><ul>";
    foreach ($buku as $id => $judul) {
        $output .= "<li>$id: $judul</li>";
    }
    $output .= "</ul>";
    return $output;
}

function pinjamBuku(&$buku, &$p_buku, $id)
{
    if (isset($buku[$id])) {
        $p_buku[$id] = $buku[$id];
        unset($buku[$id]);
        return "Anda telah meminjam: " . $p_buku[$id];
    }
    return "Buku tidak ditemukan!";
}

function kembalikanBuku(&$buku, &$p_buku, $id)
{
    if (isset($p_buku[$id])) {
        $buku[$id] = $p_buku[$id];
        unset($p_buku[$id]);
        return "Anda telah mengembalikan: " . $buku[$id];
    }
    return "Buku tidak ditemukan dalam daftar pinjaman!";
}

function tampilkanBukuDipinjam($p_buku)
{
    if (count($p_buku) == 0) {
        return "Belum pinjam buku";
    }

    $output = "<h2>Daftar buku yang dipinjam:</h2><ul>";
    foreach ($p_buku as $id => $judul) {
        $output .= "<li>$id: $judul</li>";
    }
    $output .= "</ul>";
    return $output;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? '';

    switch ($action) {
        case 'pinjam':
            $message = pinjamBuku($_SESSION['buku'], $_SESSION['p_buku'], $id);
            break;
        case 'kembalikan':
            $message = kembalikanBuku($_SESSION['buku'], $_SESSION['p_buku'], $id);
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        h2 {
            color: #007BFF;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        select,
        input[type="text"],
        button {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            background: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .daftar-buku,
        .buku-dipinjam {
            margin-top: 20px;
            padding: 15px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .message {
            padding-top: 5px;
        }

        .disabled {
            display: none;
        }
    </style>
</head>

<body>
    <h1>Sistem Manajemen Perpustakaan</h1>
    <form method="post">
        <h2>Pilih Aksi:</h2>
        <select name="action" id="actionSelect" onchange="toggleInput()">
            <option value="lihat">Lihat Daftar Buku</option>
            <option value="pinjam">Pinjam Buku</option>
            <option value="kembalikan">Kembalikan Buku</option>
        </select>
        <input type="text" name="id" id="bukuId" placeholder="Masukkan ID Buku" required>
        <button type="submit" id="submitButton">Submit</button>
    </form>

    <div class="daftar-buku">
        <?= tampilkanDaftarBuku($_SESSION['buku']); ?>
    </div>
    <div class="message"><?= $message; ?></div>
    <div class="buku-dipinjam">
        <?= tampilkanBukuDipinjam($_SESSION['p_buku']); ?>
    </div>

    <script>
        function toggleInput() {
            const actionSelect = document.getElementById('actionSelect');
            const bukuId = document.getElementById('bukuId');
            const submitButton = document.getElementById('submitButton');

            if (actionSelect.value === 'lihat') {
                bukuId.disabled = true;
                submitButton.disabled = true;
                bukuId.classList.add('disabled');
                submitButton.classList.add('disabled');
            } else {
                bukuId.disabled = false;
                submitButton.disabled = false;
                bukuId.classList.remove('disabled');
                submitButton.classList.remove('disabled');
            }
        }

        toggleInput();
    </script>
</body>

</html>