<?php include 'header.php'; ?>
<?php
include 'db.php';

if (isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $res = $conn->query("SELECT * FROM users WHERE username = '$username' AND active = 1 LIMIT 1");
    if ($res && $res->num_rows == 1) {
        $row = $res->fetch_assoc();
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_role'] = $row['role'];

            if ($row['role'] == 'admin' || $row['role'] == 'librarian') {
                header('Location: admin_dashboard.php'); exit;
            } else {
                header('Location: student_dashboard.php'); exit;
            }
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<div class="card mx-auto mt-5" style="max-width: 400px;">
  <div class="card-body">
    <h4 class="card-title mb-4">Login</h4>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="post">
      <div class="mb-3">
        <label>Username</label>
        <input name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input name="password" type="password" class="form-control" required>
      </div>
      <button class="btn btn-primary w-100" name="login">Login</button>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>