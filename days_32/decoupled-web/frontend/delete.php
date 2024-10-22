<?php
session_start();
include 'api.php';

if (!isset($_SESSION['token'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$api = new API($_SESSION['token']);

$response = $api->deleteSurvey($_GET['id']);

if ($response['success']) {
    header('Location: index.php?message=Survey berhasil dihapus');
    exit;
} else {
    header('Location: index.php?message=Gagal menghapus survei');
    exit;
}
