<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "manajemen_stok";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
