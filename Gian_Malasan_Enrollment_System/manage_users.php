<?php
include 'header.php';
include 'db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

if(isset($_POST['add'])){
    $full_name = $_POST['full_name'];
    $email = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $profile_pic = $_FILES['profile_pic']['name'];
    if($profile_pic){
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], "uploads/".$profile_pic);
    }

    $signature_img = $_FILES['signature_img']['name'];
    if($signature_img){
        move_uploaded_file($_FILES['signature_img']['tmp_name'], "uploads/".$signature_img);
    }

    $conn->query("INSERT INTO users (full_name, username, password, role, profile_pic, signature_img) VALUES ('$full_name','$email','$password','$role','$profile_pic','$signature_img')");
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
}

$users = $conn->query("SELECT * FROM users");
?>

<div class="card p-4 mt-4">
    <h3 class="mb-4">Manage Users</h3>

    <form method="post" enctype="multipart/form-data" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="col-md-2">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="col-md-2">
            <select name="role" class="form-select" required>
                <option value="">Select Role</option>
                <option value="student">Student</option>
                <option value="faculty">Faculty</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="col-md-1">
            <input type="file" name="profile_pic" class="form-control form-control-sm">
        </div>
        <div class="col-md-1">
            <input type="file" name="signature_img" class="form-control form-control-sm">
        </div>
        <div class="col-md-12 mt-2">
            <button type="submit" name="add" class="btn btn-primary">Add User</button>
        </div>
    </form>

    <table class="table table-striped table-bordered">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Role</th>
                <th>Profile</th>
                <th>Signature</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $users->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['full_name'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= ucfirst($row['role']) ?></td>
                <td>
                    <?php if($row['profile_pic']): ?>
                        <img src="uploads/<?= $row['profile_pic'] ?>" width="50" height="50" class="rounded-circle">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($row['signature_img']): ?>
                        <img src="uploads/<?= $row['signature_img'] ?>" width="80" height="50">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <a href="?delete=<?= $row['id'] ?>" class="btn btn-secondary btn-sm" onclick="return confirm('Delete user?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

