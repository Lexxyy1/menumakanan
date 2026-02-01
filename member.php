<?php 
include 'config.php';

// Proteksi: Hanya Member yang bisa masuk
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'member'){
    header("location:index.php");
    exit();
}

$user = $_SESSION['user'];
$data_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE username='$user'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Member Area - PAEDULZ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="member-page">
    <div class="container">
        <header>
            <h1>Selamat Datang, <?= $user; ?></h1>
            <p>Masa Aktif Hingga: <span class="badge"><?= $data_user['expired_date']; ?></span></p>
        </header>

        <section class="bug-panel">
            <div class="login-card">
                <h3>Kirim Perintah Bug</h3>
                <form action="send_command.php" method="POST">
                    <input type="text" name="target_num" placeholder="628xxx (Nomor Target)" required>
                    <select name="command_type">
                        <option value="v1">Bug V1 (Pesan)</option>
                        <option value="v3">Bug V3 (AESYSTM)</option>
                    </select>
                    <button type="submit" name="send" class="btn-login">EKSEKUSI</button>
                </form>
            </div>
        </section>

        <footer>
            <a href="logout.php">Keluar dari Sistem</a>
        </footer>
    </div>
</body>
</html>