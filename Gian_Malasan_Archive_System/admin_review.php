<?php include 'header.php'; ?>
<?php
include 'db.php';
if (empty($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['admin','librarian'])) {
    echo "<div class='alert alert-danger'>Access denied.</div>";
    include 'footer.php';
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    echo "<div class='alert alert-warning'>No thesis selected.</div>";
    include 'footer.php'; exit;
}

$res = $conn->query("SELECT t.*, u.full_name as submitter FROM theses t LEFT JOIN users u ON t.created_by = u.id WHERE t.id = $id LIMIT 1");
if ($res->num_rows == 0) {
    echo "<div class='alert alert-warning'>Thesis not found.</div>";
    include 'footer.php'; exit;
}
$t = $res->fetch_assoc();

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $note = $conn->real_escape_string($_POST['admin_comment']);
    $newstatus = $action === 'approve' ? 'approved' : 'rejected';
    $conn->query("UPDATE theses SET status = '$newstatus', comments_summary = '$note' WHERE id = $id");
    $uid = (int)$_SESSION['user_id'];
    $conn->query("INSERT INTO thesis_comments (thesis_id, user_id, comment) VALUES ($id, $uid, '$note')");
    header('Location: admin_dashboard.php'); exit;
}

$files = $conn->query("SELECT * FROM thesis_files WHERE thesis_id = $id");
$comments = $conn->query("SELECT c.*, u.full_name FROM thesis_comments c JOIN users u ON c.user_id = u.id WHERE c.thesis_id = $id ORDER BY c.created_at DESC");
?>
<a href="admin_dashboard.php" class="btn btn-link">&larr; Back</a>
<h3><?php echo htmlspecialchars($t['title']); ?></h3>
<p><strong>Authors:</strong> <?php echo htmlspecialchars($t['authors']); ?> | <strong>Year:</strong> <?php echo htmlspecialchars($t['year']); ?></p>
<p><strong>Abstract</strong><br><?php echo nl2br(htmlspecialchars($t['abstract'])); ?></p>

<h5>Files</h5>
<ul>
  <?php while ($f = $files->fetch_assoc()): ?>
    <li><?php echo htmlspecialchars($f['original_name']); ?> - <a href="download.php?file=<?php echo $f['id']; ?>">Download</a></li>
  <?php endwhile; ?>
</ul>

<h5>Comments</h5>
<?php while ($c = $comments->fetch_assoc()): ?>
  <div class="border p-2 mb-2"><strong><?php echo htmlspecialchars($c['full_name']); ?></strong> <small class="text-muted"><?php echo $c['created_at']; ?></small><div><?php echo nl2br(htmlspecialchars($c['comment'])); ?></div></div>
<?php endwhile; ?>

<form method="post">
  <div class="mb-3"><label>Decision note</label><textarea name="admin_comment" class="form-control"></textarea></div>
  <button name="action" value="approve" class="btn btn-success">Approve</button>
  <button name="action" value="reject" class="btn btn-danger">Reject</button>
</form>

<?php include 'footer.php'; ?>