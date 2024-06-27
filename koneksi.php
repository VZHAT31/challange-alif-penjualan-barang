<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "penjualanbarang";

// Membuat koneksi
$kon = mysqli_connect($host, $user, $password, $db);

// Memeriksa koneksi
if (!$kon) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}

// Mengatur charset ke utf8
if (!mysqli_set_charset($kon, "utf8")) {
    die("Gagal mengatur charset: " . mysqli_error($kon));
}
?>
