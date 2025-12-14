<?php include 'header.php'; ?>
<?php
include 'db.php';

if(isset($_POST['register'])){
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $full_name = $_POST['full_name'];

    $profile_pic = $_FILES['profile_pic']['name'];
    $tmp_profile = $_FILES['profile_pic']['tmp_name'];
    move_uploaded_file($tmp_profile, "uploads/".$profile_pic);

    $signature_img = $_FILES['signature_img']['name'];
    $tmp_signature = $_FILES['signature_img']['tmp_name'];
    move_uploaded_file($tmp_signature, "uploads/".$signature_img);

    $sql = "INSERT INTO users (role, username, password, full_name, profile_pic, signature_img)
            VALUES ('$role','$username','$password','$full_name','$profile_pic','$signature_img')";
    if($conn->query($sql)){
        $success = "Registration successful. You can now login.";
    } else {
        $error = "Error: ".$conn->error;
    }
}
?>

<div class="card mx-auto mt-5" style="max-width: 600px;">
    <div class="card-body">
        <h3 class="card-title mb-4">Register</h3>
        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="full_name" class="form-control" required>
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
                    <option value="faculty">Faculty</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Profile Picture</label>
                <input type="file" name="profile_pic" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Signature Image</label>
                <input type="file" name="signature_img" class="form-control" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
        </form>
    </div>
</div>

