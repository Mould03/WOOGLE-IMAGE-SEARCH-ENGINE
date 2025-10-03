<?php
require_once '../config.php';
require_once '../helpers.php';

if (is_admin_logged_in()) {
    header('Location: upload.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :u AND password = :p");
    $stmt->execute([':u' => $username, ':p' => $password]);
    $admin = $stmt->fetch();

    if ($admin) {
        $_SESSION['adminID'] = $admin['adminID'];
        $_SESSION['username'] = $admin['username'];
        header('Location: upload.php');
        exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Login - Woogle</title>
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
  <main class="container">


    <!-- Main Login Container -->
    <div class="login-container">


      <!-- Login Form -->
      <div class="login-form-container">
        <h1>Login</h1>
        <?php if ($error): ?><p class="message error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
        <form method="post" class="admin-login-form">
          <input type="text" name="username" placeholder="Username" required>
          <input type="password" name="password" placeholder="Password" required>
          <button type="submit">Login</button>
        </form>
      </div>

      <!-- Bottom UI Element -->
      <div class="bottom-ui-element"></div>
    </div>
  </main>
</body>
</html>
