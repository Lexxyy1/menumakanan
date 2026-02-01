<?php 
include 'config.php'; 

// 1. PROTEKSI: Jika bukan admin, tendang keluar
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: index.php");
    exit();
}

// 2. LOGIKA DATABASE: Tambah Member
if(isset($_POST['add_member'])){
    $u = mysqli_real_escape_string($conn, $_POST['new_user']);
    $p = mysqli_real_escape_string($conn, $_POST['new_pass']);
    $d = (int)$_POST['duration'];
    $exp = date('Y-m-d H:i:s', strtotime("+$d days"));
    mysqli_query($conn, "INSERT INTO users (username, password, role, expired_date) VALUES ('$u', '$p', 'member', '$exp')");
    header("Location: admin.php?status=success");
}

// 3. AMBIL DATA UNTUK TAMPILAN
$logs = mysqli_query($conn, "SELECT * FROM activity_logs ORDER BY time_executed DESC LIMIT 10");

// 4. PANGGIL FILE HTML MURNI
include 'admin_template.html'; 
?>