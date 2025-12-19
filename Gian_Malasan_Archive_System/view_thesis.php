<?php include 'header.php'; ?>
<?php
include 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { echo "<div class='alert alert-warning'>No thesis selected.</div>"; include 'footer.php'; exit; }

$res = $conn->query("SELECT t.*, u.full_name as submitter FROM theses t LEFT JOIN users u ON t.created_by = u.id WHERE t.id = $id AND t.status = 'approved' LIMIT 1");
if (!$res || $res->num_rows == 0) {
    echo "<div class='alert alert-warning'>Not found or not approved.</div>";
    include 'footer.php'; exit;
}
$t = $res->fetch_assoc();
$files = $conn->query("SELECT * FROM thesis_files WHERE thesis_id = $id");
?>
<a href="search.php" class="btn btn-link">&larr; Back to library</a>
<h3><?php echo htmlspecialchars($t['title']); ?></h3>
<p><strong>Authors:</strong> <?php echo htmlspecialchars($t['authors']); ?></p>
<p><strong>Abstract</strong><br><?php echo nl2br(htmlspecialchars($t['abstract'])); ?></p>

<h5>Files</h5>
<ul>
  <?php while ($f = $files->fetch_assoc()): ?>
    <li><?php echo htmlspecialchars($f['original_name']); ?> - <a href="download.php?file=<?php echo $f['id']; ?>">Download</a></li>
  <?php endwhile; ?>
</ul>

<?php include 'footer.php'; ?>