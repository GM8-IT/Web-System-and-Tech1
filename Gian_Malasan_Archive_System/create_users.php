<?php include 'header.php'; ?>
<?php
include 'db.php';
if (empty($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo "<div class='alert alert-danger'>Access denied.</div>";
    include 'footer.php'; exit;
}

if (isset($_POST['create'])) {
    $role = $conn->real_escape_string($_POST['role']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);

    $profile_pic = '';
    if (!empty($_FILES['profile_pic']['name'])) {
        $profile_pic = time() . '_' . basename($_FILES['profile_pic']['name']);
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], "uploads/profiles/" . $profile_pic);
    }

    $sql = "INSERT INTO users (role, username, password_hash, full_name, email, profile_pic)
            VALUES ('$role','$username','$password','$full_name','$email','$profile_pic')";
    if ($conn->query($sql) === TRUE) {
        $success = "User created.";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>
<div class="card mx-auto" style="max-width:700px;">
  <div class="card-body">
    <h4>Create User</h4>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3"><label>Full name</label><input name="full_name" class="form-control" required></div>
      <div class="mb-3"><label>Email</label><input name="email" class="form-control" required></div>
      <div class="mb-3"><label>Username</label><input name="username" class="form-control" required></div>
      <div class="mb-3"><label>Password</label><input name="password" class="form-control" required></div>
      <div class="mb-3"><label>Role</label>
        <select name="role" class="form-select"><option value="student">Student</option><option value="advisor">Advisor</option><option value="admin">Admin</option><option value="librarian">Librarian</option></select></div>
      <div class="mb-3"><label>Profile Picture</label><input type="file" name="profile_pic" class="form-control"></div>
      <button name="create" class="btn btn-primary">Create</button>
    </form>
  </div>
</div>
<?php include 'footer.php'; ?>