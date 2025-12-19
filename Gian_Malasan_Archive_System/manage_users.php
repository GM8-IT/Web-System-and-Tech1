<?php

include 'db.php';
include 'header.php';

if (empty($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    echo "<div class='alert alert-danger'>Access denied. Admins only.</div>";
    include 'footer.php';
    exit;
}

$res = $conn->query("SELECT u.*, d.name as dept FROM users u LEFT JOIN departments d ON u.department_id = d.id ORDER BY u.created_at DESC");
?>
<div class="d-flex justify-content-between mb-3">
  <h3>Users</h3>
  <a class="btn btn-primary" href="create_users.php">Create User</a>
</div>

<table class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>Full name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Dept</th>
      <th>Active</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($res && $res->num_rows > 0): ?>
      <?php while ($u = $res->fetch_assoc()): ?>
        <tr>
          <td><?php echo (int)$u['id']; ?></td>
          <td><?php echo htmlspecialchars($u['username']); ?></td>
          <td><?php echo htmlspecialchars($u['full_name']); ?></td>
          <td><?php echo htmlspecialchars($u['email']); ?></td>
          <td><?php echo htmlspecialchars($u['role']); ?></td>
          <td><?php echo htmlspecialchars($u['dept']); ?></td>
          <td><?php echo $u['active'] ? 'Yes' : 'No'; ?></td>
          <td>
            <a class="btn btn-sm btn-outline-secondary" href="edit_users.php?id=<?php echo (int)$u['id']; ?>">Edit</a>
          <?php echo (int)$u['id']; ?>" onclick="return confirm('Delete this user?');">Delete</a> -->
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="8" class="text-center">No users found.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<?php include 'footer.php'; ?>