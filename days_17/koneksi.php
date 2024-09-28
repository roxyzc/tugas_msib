<?php
$koneksi = mysqli_connect('localhost', 'root', '', 'rumah_sakit');

if (mysqli_connect_errno()) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
