<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Sistem Akses Paedulz</title>
    <style>
        body { background: #121212; color: white; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: #1e1e1e; padding: 30px; border-radius: 10px; width: 350px; box-shadow: 0 5px 15px rgba(0,0,0,0.5); text-align: center; }
        input { width: 100%; padding: 10px; margin: 10px 0; background: #2a2a2a; border: 1px solid #444; color: white; border-radius: 5px; }
        button { width: 100%; padding: 12px; background: #00d2ff; border: none; font-weight: bold; cursor: pointer; border-radius: 5px; }
        .error { color: #ff4d4d; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>LOGIN AKSES</h2>
        <form method="POST" action="login_process.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">MASUK</button>
        </form>
    </div>
</body>
</html>