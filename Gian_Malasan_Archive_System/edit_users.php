<?php
include 'db.php';

if (empty($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: manage_users.php');
    exit;
}

if (isset($_POST['save'])) {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $conn->real_escape_string($_POST['role']);
    $active = isset($_POST['active']) ? 1 : 0;

    $sql = "UPDATE users SET full_name = '$full_name', email = '$email', role = '$role', active = $active WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $success = "User updated successfully.";
    } else {
        $error = "Error: " . $conn->error;
    }
}

$res = $conn->query("SELECT * FROM users WHERE id = $id LIMIT 1");
if (!$res || $res->num_rows == 0) {
    header('Location: manage_users.php');
    exit;
}
$user = $res->fetch_assoc();
?>
<?php include 'header.php'; ?>

<div class="card mx-auto" style="max-width:700px;">
  <div class="card-body">
    <h4>Edit User</h4>
    <?php if (!empty($error)) echo "<div class='alert alert-danger'>" . htmlspecialchars($error) . "</div>"; ?>
    <?php if (!empty($success)) echo "<div class='alert alert-success'>" . htmlspecialchars($success) . "</div>"; ?>

    <form method="post" enctype="multipart/form-data">
      <div class="mb-3"><label>Full name</label><input name="full_name" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>"></div>
      <div class="mb-3"><label>Email</label><input name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>"></div>
      <div class="mb-3"><label>Role</label>
        <select name="role" class="form-select">
          <option value="student" <?php if($user['role']=='student') echo 'selected'; ?>>Student</option>
          <option value="advisor" <?php if($user['role']=='advisor') echo 'selected'; ?>>Advisor</option>
          <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>Admin</option>
          <option value="librarian" <?php if($user['role']=='librarian') echo 'selected'; ?>>Librarian</option>
        </select>
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" name="active" value="1" class="form-check-input" id="activeCheck" <?php if($user['active']) echo 'checked'; ?>>
        <label class="form-check-label" for="activeCheck">Active</label>
      </div>
      <button name="save" class="btn btn-primary">Save</button>
      <a class="btn btn-secondary" href="manage_users.php">Back</a>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>