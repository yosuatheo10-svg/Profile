<?php
session_start();
// Karena auth.php ada di dalam folder 'data', kita panggil db.php secara langsung (satu folder)
require 'db.php';

if (isset($_POST['action'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // --- PROSES REGISTER ---
    if ($_POST['action'] == 'register') {
        $check = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
        if (mysqli_num_rows($check) > 0) {
            // Redirect kembali ke index (keluar dari folder data)
            echo "<script>alert('Email sudah terdaftar!'); window.location='../index.php';</script>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";
            
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Pendaftaran berhasil! Silakan Login.'); window.location='../index.php';</script>";
            } else {
                echo "<script>alert('Gagal mendaftar.'); window.location='../index.php';</script>";
            }
        }
    }

    // --- PROSES LOGIN ---
    elseif ($_POST['action'] == 'login') {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['login'] = true;
                $_SESSION['email'] = $row['email'];
                // Redirect kembali ke index (keluar dari folder data)
                echo "<script>alert('Login Berhasil!'); window.location='../index.php';</script>";
            } else {
                echo "<script>alert('Password salah!'); window.location='../index.php';</script>";
            }
        } else {
            echo "<script>alert('Email tidak ditemukan!'); window.location='../index.php';</script>";
        }
    }
}

// --- PROSES LOGOUT ---
if (isset($_GET['logout'])) {
    session_destroy();
    echo "<script>window.location='../index.php';</script>";
    exit;
}
?>