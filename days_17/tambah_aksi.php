<?php


include 'koneksi.php';

session_start();

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $umur = $_POST['umur'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    if ($umur < 1 || $umur > 100) {
        $_SESSION['message'] = 'Data pasien dengan nama tersebut sudah ada.';
        header('Location: tambah.php');
        exit;
    }

    $checkSql = "SELECT * FROM m_pasien WHERE nama = '$nama' AND alamat = '$alamat' AND umur = '$umur' AND jenis_kelamin = '$jenis_kelamin'";
    $checkResult = mysqli_query($koneksi, $checkSql);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['message'] = 'Data pasien dengan nama tersebut sudah ada.';
        header('Location: tambah.php');
        exit;
    } else {
        $sql = "INSERT INTO m_pasien VALUES ('', '$nama', '$alamat', '$umur', '$jenis_kelamin')";

        if (mysqli_query($koneksi, $sql)) {
            $_SESSION['message'] = 'Data pasien berhasil di tambahkan';
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['message'] = 'Data tidak berhasil di tambahkan';
            header('Location: tambah.php');
            exit;
        }
    }
}
