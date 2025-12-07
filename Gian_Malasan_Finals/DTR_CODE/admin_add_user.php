<?php
require 'config.php';

if (!is_logged_in() || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];
    $picture = '';

    if (!empty($_FILES['picture']['name'])) {
        $picture = time() . '_' . $_FILES['picture']['name'];
        move_uploaded_file($_FILES['picture']['tmp_name'], 'uploads/' . $picture);
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (fullname, username, password, user_type, picture) VALUES (?,?,?,?,?)");
    if ($stmt->execute([$fullname, $username, $hash, $user_type, $picture])) {
        header('Location: admin.php');
        exit;
    } else {
        $err = "Error adding user.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="container p-4">
<h3>Add User</h3>

<?php if($err): ?>
<div class="alert alert-danger"><?php echo esc($err); ?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <div class="mb-2"><input name="fullname" class="form-control" placeholder="Full Name" required></div>
    <div class="mb-2"><input name="username" class="form-control" placeholder="Username" required></div>
    <div class="mb-2"><input name="password" type="password" class="form-control" placeholder="Password" required></div>
    <div class="mb-2">
        <select name="user_type" class="form-control" required>
            <option value="faculty">Faculty</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <div class="mb-2">
        <label>Picture</label>
        <input type="file" name="picture" class="form-control">
    </div>
    <button class="btn btn-success">Add User</button>
    <div class="mt-3 text-center">
    <a href="admin.php" class="btn btn-success">Cancel</a>
    </div>
</form>
</body>
</html>
