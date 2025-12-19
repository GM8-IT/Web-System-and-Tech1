<?php include 'header.php'; ?>
<?php
include 'db.php';
if (empty($_SESSION['user_id'])) { header('Location: login.php'); exit; }

if (isset($_POST['submit_thesis'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $authors = $conn->real_escape_string($_POST['authors']);
    $abstract = $conn->real_escape_string($_POST['abstract']);
    $keywords = $conn->real_escape_string($_POST['keywords']);
    $year = (int)$_POST['year'];
    $access_level = $conn->real_escape_string($_POST['access_level']);
    $embargo_until = !empty($_POST['embargo_until']) ? $conn->real_escape_string($_POST['embargo_until']) : NULL;
    $created_by = (int)$_SESSION['user_id'];

    $sql = "INSERT INTO theses (title, abstract, keywords, authors, year, status, access_level, embargo_until, created_by)
            VALUES ('$title','$abstract','$keywords','$authors',$year,'submitted','$access_level', " . ($embargo_until ? "'$embargo_until'" : "NULL") . ", $created_by)";
    if ($conn->query($sql) === TRUE) {
        $thesis_id = $conn->insert_id;

        if (!empty($_FILES['file_pdf']['name'])) {
            $filename = time() . '_' . basename($_FILES['file_pdf']['name']);
            $target = "uploads/theses/" . $filename;
            if (move_uploaded_file($_FILES['file_pdf']['tmp_name'], $target)) {
                $mime = mime_content_type($target);
                $size = filesize($target);
                $checksum = hash_file('sha256', $target);
                $ins = "INSERT INTO thesis_files (thesis_id, original_name, stored_name, mime_type, size_bytes, storage_path, checksum, uploaded_by)
                        VALUES ($thesis_id, '" . $conn->real_escape_string($_FILES['file_pdf']['name']) . "', '$filename', '" . $conn->real_escape_string($mime) . "', $size, '" . $conn->real_escape_string($target) . "', '$checksum', $created_by)";
                $conn->query($ins);
                $success = "Thesis submitted successfully.";
            } else {
                $error = "File upload failed.";
            }
        } else {
            $error = "Please upload a thesis PDF file.";
        }
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<div class="card mx-auto" style="max-width: 900px;">
  <div class="card-body">
    <h4>Submit Thesis</h4>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label>Title</label>
        <input name="title" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Authors (comma separated)</label>
        <input name="authors" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Abstract</label>
        <textarea name="abstract" class="form-control" rows="4"></textarea>
      </div>
      <div class="mb-3">
        <label>Keywords</label>
        <input name="keywords" class="form-control">
      </div>
      <div class="mb-3 row">
        <div class="col">
          <label>Year</label>
          <input name="year" type="number" class="form-control" min="1900" max="<?php echo date('Y'); ?>">
        </div>
        <div class="col">
          <label>Access Level</label>
          <select name="access_level" class="form-select">
            <option value="public">Public</option>
            <option value="embargoed">Embargoed</option>
            <option value="restricted">Restricted</option>
          </select>
        </div>
        <div class="col">
          <label>Embargo Until</label>
          <input name="embargo_until" type="date" class="form-control">
        </div>
      </div>
      <div class="mb-3">
        <label>Thesis File (PDF)</label>
        <input type="file" name="file_pdf" accept="application/pdf" class="form-control" required>
      </div>
      <button name="submit_thesis" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>