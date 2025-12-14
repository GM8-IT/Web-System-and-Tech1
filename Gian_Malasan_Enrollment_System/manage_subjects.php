<?php
include 'header.php';
include 'db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

if(isset($_POST['add'])){
    $code = $_POST['code'];
    $title = $_POST['title'];
    $prereq = $_POST['prerequisite'] == "" ? "NULL" : $_POST['prerequisite'];
    $conn->query("INSERT INTO subjects (code, title, prerequisite_id) VALUES ('$code','$title',$prereq)");
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $check = $conn->query("SELECT * FROM enrollments WHERE subject_id=$id");
    if($check->num_rows > 0){
        echo "<script>alert('Cannot delete subject: students are enrolled.'); window.location='manage_subjects.php';</script>";
    } else {
        $conn->query("DELETE FROM subjects WHERE id=$id");
        header("Location: manage_subjects.php"); // refresh page
    }
}


$result = $conn->query("SELECT s.*, p.title as prereq_title FROM subjects s LEFT JOIN subjects p ON s.prerequisite_id=p.id");
?>

<div class="card p-4 mt-4">
    <h3 class="mb-4">Manage Subjects</h3>

    <form method="post" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="code" class="form-control" placeholder="Subject Code" required>
        </div>
        <div class="col-md-4">
            <input type="text" name="title" class="form-control" placeholder="Subject Title" required>
        </div>
        <div class="col-md-3">
            <select name="prerequisite" class="form-select">
                <option value="">No Prerequisite</option>
                <?php
                $preq_res = $conn->query("SELECT * FROM subjects");
                while($pre = $preq_res->fetch_assoc()){
                    echo "<option value='".$pre['id']."'>".$pre['title']."</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" name="add" class="btn btn-primary w-100">Add Subject</button>
        </div>
    </form>

    <table class="table table-striped table-bordered">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Title</th>
                <th>Prerequisite</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['code'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['prereq_title'] ?? '-' ?></td>
                <td>
                    <a href="?delete=<?= $row['id'] ?>" class="btn btn-secondary btn-sm" onclick="return confirm('Delete subject?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

