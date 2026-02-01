<?php
include 'config.php';

if(isset($_POST['login'])){
    $u = mysqli_real_escape_string($conn, $_POST['username']);
    $p = mysqli_real_escape_string($conn, $_POST['password']);
    
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$u' AND password='$p'");
    
    if(mysqli_num_rows($query) > 0){
        $data = mysqli_fetch_assoc($query);
        
        // Simpan ke Session
        $_SESSION['user'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        // Cek Expired untuk Member
        $sekarang = date('Y-m-d H:i:s');
        if($data['role'] == 'member' && !empty($data['expired_date']) && $sekarang > $data['expired_date']){
            session_destroy();
            echo "<script>alert('Akun Member Expired!'); window.location='index.php';</script>";
            exit();
        }

        // Redirect sesuai role di database
        if($data['role'] == 'admin') {
            header("location:admin.php");
        } else if($data['role'] == 'member') {
            header("location:member.php");
        }
        exit();
    } else {
        echo "<script>alert('Akun tidak terdaftar sebagai Admin atau Member!'); window.location='index.php';</script>";
    }
}
?>