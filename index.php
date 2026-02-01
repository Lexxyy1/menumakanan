<?php
include 'config.php';

// Jika sudah login, langsung lempar ke dashboard
if(isset($_SESSION['role'])){
    if($_SESSION['role'] == 'admin') header("Location: admin.php");
    else if($_SESSION['role'] == 'member') header("Location: member.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - Paedulz Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-card">
        <h1>PAEDULZ PANEL</h1>
        <form action="login_process.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="btn-login">MASUK SISTEM</button>
        </form>
    </div>
</body>
</html>