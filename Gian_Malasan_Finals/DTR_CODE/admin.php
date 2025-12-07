<?php
require 'config.php';
if (!is_logged_in() || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    $stmt = $pdo->prepare("SELECT picture FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if ($user) {
        if (!empty($user['picture']) && file_exists('uploads/'.$user['picture'])) {
            unlink('uploads/' . $user['picture']);
        }

        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }

    header('Location: admin.php');
    exit;
}

$keyword = isset($_GET['search']) ? "%".$_GET['search']."%" : "%";
$order = isset($_GET['sort']) ? $_GET['sort'] : "id";
$allowed = ['id','fullname','username','user_type'];

if (!in_array($order, $allowed)) $order = 'id';

$stmt = $pdo->prepare("
    SELECT * FROM users
    WHERE fullname LIKE ? OR username LIKE ?
    ORDER BY $order ASC
");

$stmt->execute([$keyword, $keyword]);
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="p-4">
<h2>Admin Dashboard</h2><br>
<div class="mb-3 d-flex justify-content-between align-items-center">
    <div>
        Logged in as: <strong><?= $_SESSION['fullname'] ?></strong> (<?= $_SESSION['user_type'] ?>)
    </div>
    <div class="btn-group">
        <a href="logout.php" class="btn btn-secondary">Logout</a>
        <a href="admin_add_user.php" class="btn btn-success">Add User</a>
    </div>
</div>
<br><br>

<form method="get" class="mb-3 d-flex">
    <input type="text" name="search" class="form-control me-2" placeholder="Search users..."
           value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <select name="sort" class="form-select me-2" style="max-width: 180px;">
        <option value="id" <?= $order=='id'?'selected':'' ?>>Sort by ID</option>
        <option value="fullname" <?= $order=='fullname'?'selected':'' ?>>Sort by Full Name</option>
        <option value="username" <?= $order=='username'?'selected':'' ?>>Sort by Username</option>
        <option value="user_type" <?= $order=='user_type'?'selected':'' ?>>Sort by Type</option>
    </select>
    <button class="btn btn-primary">Search</button>

</form><br>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Username</th>
        <th>Type</th>
        <th>Picture</th>
        <th>Action</th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['fullname']) ?></td>
            <td><?= htmlspecialchars($u['username']) ?></td>
            <td><?= $u['user_type'] ?></td>
            <td>
                <?php if ($u['picture']): ?>
                    <img src="uploads/<?= htmlspecialchars($u['picture']) ?>" width="50">
                <?php endif; ?>
            </td>
            <td>
                <a class="btn btn-danger btn-sm"
                   onclick="return confirm('Delete this user?')"
                   href="?delete=<?= $u['id'] ?>">
                    Delete
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
