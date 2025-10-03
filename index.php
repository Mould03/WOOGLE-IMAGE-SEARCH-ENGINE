<?php
require_once 'config.php';

// Handle logout for admin
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$results = [];

if ($q !== '') {
    $stmt = $pdo->prepare("SELECT imageID, caption, imagePath FROM gallery WHERE caption LIKE :kw ORDER BY timeUploaded DESC");
    $stmt->execute([':kw' => "%{$q}%"]);
    $results = $stmt->fetchAll();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Woogle - Image Search</title>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>
<main class="container">
<h1>Woogle</h1>

<!-- Search Form - Available to all users -->
<form method="get" class="search-form">
    <input type="text" name="q" placeholder="Search images..." value="<?= htmlspecialchars($q) ?>" required>
    <button type="submit">Search</button>
</form>

<!-- Admin Login Link -->
<div class="admin-section">
    <a href="admin/login.php" class="admin-link">Admin Login</a>
</div>

<!-- Search Results -->
<?php if ($q !== ''): ?>
<div class="results-section">
    <h2><?= count($results) ?> results found</h2>
    <?php if (empty($results)): ?>
    <p class="no-results">No matches found.</p>
    <?php else: ?>
    <div class="grid">
    <?php foreach ($results as $img): ?>
    <a href="view.php?id=<?= $img['imageID'] ?>">
    <img src="uploads/<?= htmlspecialchars($img['imagePath']) ?>" alt="<?= htmlspecialchars($img['caption']) ?>">
    <div><?= htmlspecialchars($img['caption']) ?></div>
    </a>
    <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
</main>
</body>
</html>
