<?php
require_once '../config.php';
require_once '../helpers.php';
require_admin();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caption = trim($_POST['caption'] ?? '');
    $file = $_FILES['image'] ?? null;

    if ($caption && $file && $file['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = uniqid() . '.' . $ext;
        $uploadPath = __DIR__ . '/../uploads/' . $newName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $stmt = $pdo->prepare("INSERT INTO gallery (caption, imagePath, uploadedBy) VALUES (:c, :p, :u)");
            $stmt->execute([
                ':c' => $caption,
                ':p' => $newName,
                ':u' => $_SESSION['adminID']
            ]);
            $message = "Image uploaded successfully.";
        } else {
            $message = "File upload failed.";
        }
    } else {
        $message = "Caption and image are required.";
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Upload Image</title>
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
  <main class="container">
    <div class="admin-nav">
      <h1>Upload Image</h1>
      <div>
        <a href="../index.php?logout=1">Logout</a>
        <a href="../index.php">View Gallery</a>
      </div>
    </div>
    <?php if ($message): ?><p class="message success"><?= htmlspecialchars($message) ?></p><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
      <input type="text" name="caption" placeholder="Image Caption" required>
      <input type="file" name="image" accept="image/*" required>
      <button type="submit">Upload Image</button>
    </form>
  </main>
</body>
</html>
