<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function cek_login() {
    if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
        header("Location: login.php");
        exit;
    }
}

function hanya_admin() {
    cek_login();

    if ($_SESSION['role'] != 'admin') {
        header("Location: dashboard.php");
        exit;
    }
}

function hanya_verifikator() {
    cek_login();

    if ($_SESSION['role'] != 'verifikator') {
        header("Location: dashboard.php");
        exit;
    }
}

function admin_atau_verifikator() {
    cek_login();

    if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'verifikator') {
        header("Location: dashboard.php");
        exit;
    }
}
?>