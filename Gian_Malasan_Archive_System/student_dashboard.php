<?php include 'header.php'; ?>
<?php
include 'db.php';
if (empty($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$uid = (int)$_SESSION['user_id'];

$res = $conn->query("SELECT * FROM theses WHERE created_by = $uid ORDER BY created_at DESC");
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>My Submissions</h3>
  <a href="submit_thesis.php" class="btn btn-primary">Submit New Thesis</a>
</div>

<table class="table table-striped">
  <thead><tr><th>Title</th><th>Year</th><th>Status</th><th>Actions</th></tr></thead>
  <tbody>
    <?php while ($t = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($t['title']); ?></td>
        <td><?php echo htmlspecialchars($t['year']); ?></td>
        <td><?php echo htmlspecialchars($t['status']); ?></td>
        <td>
          <a class="btn btn-sm btn-outline-primary" href="view_thesis.php?id=<?php echo $t['id']; ?>">View</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include 'footer.php'; ?>