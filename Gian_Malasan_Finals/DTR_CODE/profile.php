<?php
require 'config.php';
if (!is_logged_in()) header('Location: login.php');

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
if (!$user) { session_destroy(); header('Location: login.php'); exit; }

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
<div class="d-flex justify-content-between">
<h3>Welcome, <?php echo esc($user['fullname']); ?></h3>
<div>
<?php if($_SESSION['user_type']==='admin'): ?>
<a href="admin.php" class="btn btn-outline-primary">Admin Panel</a>
<?php endif; ?>
<a href="logout.php" class="btn btn-outline-secondary">Logout</a>
</div>
</div>

<hr>
<div class="row">
<div class="col-md-3 text-center">
<?php if($user['picture']): ?>
<img src="uploads/<?php echo esc($user['picture']); ?>" class="profile-pic" alt="pic">
<?php else: ?>
<div class="profile-pic d-flex align-items-center justify-content-center small">No picture</div>
<?php endif; ?>
<p class="mt-2 small">Type: <?php echo esc($user['user_type']); ?></p>
<a href="delete_account.php" class="btn btn-danger btn-sm" onclick="return confirm('Delete your account? This cannot be undone.')">Delete account</a>
</div>
<div class="col-md-9">
<h5>Account details</h5>
<table class="table table-bordered">
<tr><th>Username</th><td><?php echo esc($user['username']); ?></td></tr>
<tr><th>Full name</th><td><?php echo esc($user['fullname']); ?></td></tr>
<tr><th>Joined</th><td><?php echo esc($user['created_at']); ?></td></tr>
</table>

<h5>Daily Time Record (DTR)</h5>
<p class="small">......</p>
</div>
</div>
</div>
</body>
</html>