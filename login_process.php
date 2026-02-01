<?php
include 'config.php';
if(isset($_POST['login'])){
    $u = $_POST['username'];
    $p = $_POST['password'];
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$u' AND password='$p'");
    if(mysqli_num_rows($query) > 0){
        $data = mysqli_fetch_assoc($query);
        $_SESSION['user'] = $data['username'];
        $_SESSION['role'] = $data['role'];
        if($data['role'] == 'admin') { header("location:admin.php"); }
        else { header("location:member.php"); }
    } else { echo "<script>alert('Login Gagal!'); window.location='index.php';</script>"; }
}
?>