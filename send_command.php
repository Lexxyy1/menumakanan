<?php
include 'config.php';
if (isset($_POST['send'])) {
    $user = $_SESSION['user'];
    $target = $_POST['target_num'];
    $cmd = $_POST['command_type'];
    $waktu = date('Y-m-d H:i:s');

    // Catat ke Database
    mysqli_query($conn, "INSERT INTO activity_logs (username, target_num, command_type, time_executed) 
                         VALUES ('$user', '$target', '$cmd', '$waktu')");

    // Kirim Perintah ke Bot Node.js (Port 3000)
    $url = "http://localhost:3000/api/execute";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['target' => $target, 'command' => $cmd]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
    
    echo "<script>alert('Perintah Bug Terkirim!'); window.location='admin.php';</script>";
}
?>