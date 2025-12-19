<?php include 'header.php'; ?>
<?php
include 'db.php';
if (empty($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['admin','librarian'])) {
    echo "<div class='alert alert-danger'>Access denied.</div>";
    include 'footer.php'; exit;
}

$res = $conn->query("SELECT t.*, u.full_name as submitter FROM theses t LEFT JOIN users u ON t.created_by = u.id ORDER BY t.created_at DESC LIMIT 100");
?>
<div class="d-flex justify-content-between mb-3">
  <h3>Admin Dashboard</h3>
  <div>
    <a class="btn btn-outline-secondary" href="manage_users.php">Manage Users</a>
  </div>
</div>

<h5>Recent Submissions</h5>
<table class="table">
  <thead><tr><th>Title</th><th>Submitter</th><th>Status</th><th>Actions</th></tr></thead>
  <tbody>
    <?php while ($r = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($r['title']); ?></td>
        <td><?php echo htmlspecialchars($r['submitter']); ?></td>
        <td><?php echo htmlspecialchars($r['status']); ?></td>
        <td>
          <a class="btn btn-sm btn-primary" href="admin_review.php?id=<?php echo $r['id']; ?>">Review</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include 'footer.php'; ?>