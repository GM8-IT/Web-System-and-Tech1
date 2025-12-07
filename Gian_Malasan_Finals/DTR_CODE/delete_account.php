<?php
require 'config.php';
if (!is_logged_in()) header('Location: login.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

$stmt = $pdo->prepare('SELECT picture FROM users WHERE id=?');
$stmt->execute([$_SESSION['user_id']]);
$u = $stmt->fetch();

if ($u && $u['picture']) {
@unlink(__DIR__ . '/uploads/' . $u['picture']);
}

$pdo->prepare('DELETE FROM users WHERE id=?')->execute([$_SESSION['user_id']]);
session_unset(); session_destroy();
header('Location: register.php'); exit;
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Delete Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<div class="form-container">
    <h3>Confirm Delete Account</h3>
    <p>Are you sure you want to delete your account? This action cannot be undone.</p>
    <form method="post">
        <button type="submit" class="btn btn-danger">Confirm Delete</button>
        <a href="profile.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
