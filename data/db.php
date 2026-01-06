<?php
$host = "localhost";
$user = "root";      // Sesuaikan dengan user database kamu
$pass = "Trilytr246";          // Sesuaikan dengan password database kamu
$db   = "db_profil"; // Sesuaikan dengan nama database kamu

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>