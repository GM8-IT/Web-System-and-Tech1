<?php
require 'config.php';
$err = '';
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username=?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $err = "Username already exists.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (fullname, username, password, user_type) VALUES (?,?,?,?)");
        $stmt->execute([$fullname, $username, $hash, $user_type]);
        header('Location: login.php');
        exit;
    }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Register - DTR</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
</head>
<body>

<div class="form-container">
    <h3><i class="bi"></i> Register</h3>

    <?php if($err): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
    <?php endif; ?>

    <form method="post">
        <input name="fullname" class="form-control" placeholder="Full Name" required>
        <input name="username" class="form-control" placeholder="Username" required>
        <input name="password" type="password" class="form-control" placeholder="Password" required>
        <select name="user_type" class="form-control mb-2" required>
            <option value="faculty">Faculty</option>
            <option value="admin">Admin</option>
        </select>
        <button class="btn btn-success"><i class="bi bi-person-plus"></i> Register</button>
        <div class="mt-3 text-center">
            <a href="login.php" class="btn-link">Already have an account? Login</a>
        </div>
    </form>
</div>

</body>
</html>
