<?php include 'header.php'; ?>
<?php
include 'db.php';
if (empty($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$uid = (int)$_SESSION['user_id'];

if (isset($_POST['save'])) {
    if (!empty($_FILES['profile_pic']['name'])) {
        $profile_pic = time() . '_' . basename($_FILES['profile_pic']['name']);
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], "uploads/profiles/" . $profile_pic);
        $conn->query("UPDATE users SET profile_pic = '" . $conn->real_escape_string($profile_pic) . "' WHERE id = $uid");
    }
    if (!empty($_FILES['signature']['name'])) {
        $signature = time() . '_sig_' . basename($_FILES['signature']['name']);
        move_uploaded_file($_FILES['signature']['tmp_name'], "uploads/profiles/" . $signature);
        $conn->query("UPDATE users SET signature_pic = '" . $conn->real_escape_string($signature) . "' WHERE id = $uid");
    }
    header('Location: profile.php'); exit;
}

$res = $conn->query("SELECT * FROM users WHERE id = $uid LIMIT 1");
$user = $res->fetch_assoc();
?>
<div class="card mx-auto" style="max-width:700px;">
  <div class="card-body">
    <h4>Profile — <?php echo htmlspecialchars($user['full_name']); ?></h4>
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label>Profile picture (JPEG/PNG)</label>
        <input type="file" name="profile_pic" class="form-control">
        <?php if (!empty($user['profile_pic'])): ?>
          <img src="uploads/profiles/<?php echo htmlspecialchars($user['profile_pic']); ?>" style="max-height:80px;margin-top:8px;">
        <?php endif; ?>
      </div>
      <div class="mb-3">
        <label>Signature image (JPEG/PNG)</label>
        <input type="file" name="signature" class="form-control">
        <?php if (!empty($user['signature_pic'])): ?>
          <img src="uploads/profiles/<?php echo htmlspecialchars($user['signature_pic']); ?>" style="max-height:60px;margin-top:8px;">
        <?php endif; ?>
      </div>
      <button name="save" class="btn btn-primary">Upload</button>
    </form>
  </div>
</div>
<?php include 'footer.php'; ?>