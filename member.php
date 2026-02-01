<?php 
include 'config.php';
if(!isset($_SESSION['user'])){ header("location:index.php"); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Halaman Akses</title>
    <style>body { background: #121212; color: white; text-align: center; padding-top: 100px; font-family: sans-serif; }</style>
</head>
<body>
    <h1>Selamat Datang, <?= $_SESSION['user']; ?></h1>
    <p>Status Akses: <span style="color: #00d2ff;">Trial Aktif</span></p>
    <div style="background: #1e1e1e; padding: 20px; display: inline-block; border-radius: 10px;">
        <p>Anda sekarang bisa menggunakan layanan ini.</p>
    </div>
    <br><br>
    <a href="logout.php" style="color: red;">Logout</a>
</body>
</html>