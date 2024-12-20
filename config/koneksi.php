<?php
// config/koneksi.php
// Konfigurasi database
$host = 'localhost';  // nama host database, biasanya 'localhost'
$dbname = 'database_sekolah';  // ganti dengan nama database Anda
$username = 'root';  // sesuai permintaan, username adalah 'root'
$password = '';  // sesuai permintaan, password kosong

// Mencoba membuat koneksi
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Set mode error PDO ke exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set default fetch mode ke associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // echo "Koneksi berhasil";  // Uncomment ini jika Anda ingin melihat pesan sukses
} catch (PDOException $e) {
    // Jika terjadi error, tampilkan pesannya
    die("Koneksi gagal: " . $e->getMessage());
}