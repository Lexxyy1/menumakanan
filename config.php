<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "user_system");
if (!$conn) { die("Koneksi Database Gagal!"); }
date_default_timezone_set('Asia/Jakarta');
?>