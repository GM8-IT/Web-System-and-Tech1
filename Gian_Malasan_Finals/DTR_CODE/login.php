<?php
require 'config.php';
$err = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])){
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['fullname']  = $user['fullname'];
        $_SESSION['user_type'] = $user['user_type'];

        if($user['user_type']==='admin'){
            header('Location: admin.php');
        } else {
            header('Location: profile.php');
        }
        exit;
    } else { $err = 'Invalid username or password.'; }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
</head>
<body>

<div class="form-container">
    <h3><i class="bi bi-box-arrow-in-right"></i> Login</h3>

    <?php if($err): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($err); ?></div>
    <?php endif; ?>

    <form method="post">
        <input name="username" class="form-control" placeholder="Username" required>
        <input name="password" type="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-success"><i class="bi bi-box-arrow-in-right"></i> Login</button>
        <div class="mt-3 text-center">
            <a href="register.php" class="btn-link">Don't have an account? Register</a>
        </div>
    </form>
</div>
</body>
</html>
