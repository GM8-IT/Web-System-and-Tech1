<?php include 'header.php'; ?>
<?php
include 'db.php';

if (isset($_POST['register'])) {
    $role = $conn->real_escape_string($_POST['role']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);

    $profile_pic = '';
    if (!empty($_FILES['profile_pic']['name'])) {
        $profile_pic = time() . '_' . basename($_FILES['profile_pic']['name']);
        $tmp_profile = $_FILES['profile_pic']['tmp_name'];
        move_uploaded_file($tmp_profile, "uploads/profiles/" . $profile_pic);
    }

    $signature_img = '';
    if (!empty($_FILES['signature_img']['name'])) {
        $signature_img = time() . '_sig_' . basename($_FILES['signature_img']['name']);
        $tmp_signature = $_FILES['signature_img']['tmp_name'];
        move_uploaded_file($tmp_signature, "uploads/profiles/" . $signature_img);
    }

    $check = $conn->query("SELECT id FROM users WHERE username = '$username' OR email = '$email' LIMIT 1");
    if ($check && $check->num_rows > 0) {
        $error = "Username or email already exists.";
    } else {
        $sql = "INSERT INTO users (role, username, password_hash, full_name, email, profile_pic, signature_pic)
                VALUES ('$role','$username','$password','$full_name','$email','$profile_pic','$signature_img')";

        if ($conn->query($sql) === TRUE) {
            $success = "Registration successful. You can now login.";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<div class="card mx-auto mt-3" style="max-width: 700px;">
  <div class="card-body">
    <h3 class="card-title mb-4">Register</h3>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label>Full Name</label>
        <input type="text" name="full_name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-select" required>
          <option value="student">Student</option>
          <option value="advisor">Advisor</option>
          <option value="admin">Administrator</option>
          <option value="librarian">Librarian</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Profile Picture</label>
        <input type="file" name="profile_pic" class="form-control">
      </div>
      <div class="mb-3">
        <label>Signature Image</label>
        <input type="file" name="signature_img" class="form-control">
      </div>
      <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>