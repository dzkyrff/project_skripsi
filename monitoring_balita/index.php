<?php
session_start();

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
  header("Location: dashboard.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Monitoring Balita</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #74ebd5, #9face6);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      width: 100%;
      max-width: 400px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      border-radius: 15px;
    }
    .logo {
      max-width: 100px;
      display: block;
      margin: 0 auto 15px;
    }
  </style>
</head>
<body>
  <div class="card p-4">
    <img src="assets/logo-posyandu.png" alt="Logo Posyandu" class="logo">
    <h4 class="text-center mb-3">Login Petugas Posyandu</h4>
    
    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger">
        <?= htmlspecialchars($_GET['error']); ?>
      </div>
    <?php endif; ?>

    <form action="cek_login.php" method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" id="username" name="username" class="form-control" required autofocus>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>