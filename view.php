<?php
require_once 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT g.*, a.username FROM gallery g 
                       JOIN admin a ON g.uploadedBy = a.adminID
                       WHERE g.imageID = :id");
$stmt->execute([':id' => $id]);
$image = $stmt->fetch();

if (!$image) {
    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($image['caption']) ?></title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <main class="container view-container">
    <div class="nav-bar">
      <a href="index.php" class="back-btn">← Back to Search</a>
      <a href="admin/login.php" class="admin-link">Admin Login</a>
    </div>
    <h1><?= htmlspecialchars($image['caption']) ?></h1>
    <img src="uploads/<?= htmlspecialchars($image['imagePath']) ?>" alt="<?= htmlspecialchars($image['caption']) ?>">
    <div class="image-info">
      <p><strong>Uploaded by:</strong> <?= htmlspecialchars($image['username']) ?></p>
      <p><strong>Time:</strong> <?= htmlspecialchars($image['timeUploaded']) ?></p>
    </div>
  </main>
</body>
</html>
