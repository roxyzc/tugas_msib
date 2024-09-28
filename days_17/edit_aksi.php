<?php

include 'koneksi.php';
session_start();

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $umur = $_POST['umur'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    if ($umur < 1 || $umur > 100) {
        $_SESSION['message'] = 'Masukkan umur dengan benar.';
        header("Location: edit.php?id=$id");
        exit;
    }

    $checkSql = "SELECT * FROM m_pasien WHERE nama = '$nama' AND alamat = '$alamat' AND umur = '$umur' AND jenis_kelamin = '$jenis_kelamin' AND id != '$id'";
    $checkResult = mysqli_query($koneksi, $checkSql);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['message'] = 'Data pasien sudah ada. Silakan gunakan data yang berbeda.';
        header("Location: edit.php?id=$id");
        exit;
    }

    $updateSql = "UPDATE m_pasien SET nama='$nama', alamat='$alamat', umur='$umur', jenis_kelamin='$jenis_kelamin' WHERE id='$id'";

    if (mysqli_query($koneksi, $updateSql)) {
        $_SESSION['message'] = 'Data pasien berhasil diperbarui.';
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['message'] = 'Data tidak berhasil diperbarui.';
        header("Location: edit.php?id=$id");
        exit;
    }
}
