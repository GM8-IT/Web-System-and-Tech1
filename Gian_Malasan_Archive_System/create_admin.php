<?php
include 'db.php';

if (isset($_POST['create'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);

    $sql = "INSERT INTO users (role, username, password_hash, full_name, email) VALUES ('admin','$username','$password','$full_name','$email')";
    if ($conn->query($sql) === TRUE) {
        echo "Admin created. Delete this file (create_admin.php) for security.";
    } else {
        echo "Error: " . $conn->error;
    }
    exit;
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Create Admin</title></head><body>
<form method="post">
  <input name="username" placeholder="username"><br>
  <input name="password" placeholder="password"><br>
  <input name="full_name" placeholder="Full name"><br>
  <input name="email" placeholder="admin@example.com"><br>
  <button name="create">Create Admin</button>
</form>

</body></html>
