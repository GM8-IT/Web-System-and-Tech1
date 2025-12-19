<?php include 'header.php'; ?>
<?php
include 'db.php';

$q = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';
$year = isset($_GET['year']) ? (int)$_GET['year'] : 0;
$adviser = isset($_GET['adviser']) ? (int)$_GET['adviser'] : 0;

$sql = "SELECT t.* FROM theses t WHERE status='approved' ";
if ($q !== '') {
    $like = "%$q%";
    $sql .= "AND (t.title LIKE '$like' OR t.abstract LIKE '$like' OR t.authors LIKE '$like' OR t.keywords LIKE '$like') ";
}
if ($year > 0) {
    $sql .= "AND t.year = $year ";
}
if ($adviser > 0) {
    $sql .= "AND t.adviser_id = $adviser ";
}
$sql .= "ORDER BY t.created_at DESC LIMIT 200";

$res = $conn->query($sql);
$advisers = $conn->query("SELECT id, full_name FROM users WHERE role IN ('advisor','admin')");
?>
<h3>Thesis Library</h3>

<form class="row g-2 mb-3">
  <div class="col-md-6"><input name="q" value="<?php echo htmlspecialchars($q); ?>" class="form-control" placeholder="Search title, abstract, author, keywords"></div>
  <div class="col-auto"><input name="year" value="<?php echo $year ? $year : ''; ?>" class="form-control" placeholder="Year" style="width:120px"></div>
  <div class="col-auto">
    <select name="adviser" class="form-select">
      <option value="">Adviser</option>
      <?php while ($a = $advisers->fetch_assoc()): ?>
        <option value="<?php echo $a['id']; ?>" <?php if ($adviser == $a['id']) echo 'selected'; ?>><?php echo htmlspecialchars($a['full_name']); ?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="col-auto"><button class="btn btn-primary">Search</button></div>
</form>

<div>
  <?php while ($r = $res->fetch_assoc()): ?>
    <div class="border p-3 mb-2">
      <h5><a href="view_thesis.php?id=<?php echo $r['id']; ?>"><?php echo htmlspecialchars($r['title']); ?></a></h5>
      <div><strong>Authors:</strong> <?php echo htmlspecialchars($r['authors']); ?> | <strong>Year:</strong> <?php echo htmlspecialchars($r['year']); ?></div>
      <p><?php echo htmlspecialchars(mb_strimwidth($r['abstract'], 0, 300, '...')); ?></p>
    </div>
  <?php endwhile; ?>
</div>

<?php include 'footer.php'; ?>