<?php
session_start();
// Ganti dengan data dari database online Anda
$conn = mysqli_connect("HOST_ONLINE_ANDA", "USER_ONLINE", "PASS_ONLINE", "NAMA_DB_ONLINE");

if (!$conn) { 
    die("Koneksi Database Gagal!"); 
}
date_default_timezone_set('Asia/Jakarta');
?>