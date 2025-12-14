<?php
include 'header.php';
include 'db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student'){
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['user_id'];

if(isset($_POST['enroll'])){
    $subject_id = $_POST['subject_id'];

    $sub = $conn->query("SELECT prerequisite_id, title FROM subjects WHERE id=$subject_id")->fetch_assoc();
    $prereq_id = $sub['prerequisite_id'];

    if($prereq_id){
        $check = $conn->query("SELECT * FROM enrollments WHERE student_id=$student_id AND subject_id=$prereq_id AND status='completed'");
        if($check->num_rows == 0){
            $error = "Cannot enroll in '{$sub['title']}'. Prerequisite not completed.";
        } else {
            $conn->query("INSERT INTO enrollments (student_id, subject_id, status) VALUES ($student_id, $subject_id, 'enrolled')");
            $success = "Enrolled in '{$sub['title']}' successfully!";
        }
    } else {
        $conn->query("INSERT INTO enrollments (student_id, subject_id, status) VALUES ($student_id, $subject_id, 'enrolled')");
        $success = "Enrolled in '{$sub['title']}' successfully!";
    }
}

$subjects = $conn->query("SELECT * FROM subjects");

$enrollments = $conn->query("
    SELECT e.*, s.title 
    FROM enrollments e 
    JOIN subjects s ON e.subject_id=s.id 
    WHERE student_id=$student_id
    ORDER BY s.title
");
?>

<div class="card p-4 mt-4">
    <h3 class="mb-4">Enroll Subjects</h3>

    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <?php if(isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <div class="row g-3 mb-4">
        <?php while($subj = $subjects->fetch_assoc()): ?>
            <div class="col-md-3">
                <form method="post" class="card p-3 h-100">
                    <h5 class="card-title"><?= $subj['title'] ?></h5>
                    <p class="card-text">Code: <?= $subj['code'] ?></p>
                    <?php if($subj['prerequisite_id']): ?>
                        <?php
                            $preq = $conn->query("SELECT title FROM subjects WHERE id=".$subj['prerequisite_id'])->fetch_assoc();
                        ?>
                        <p class="text-warning">Prerequisite: <?= $preq['title'] ?></p>
                    <?php else: ?>
                        <p class="text-success">No Prerequisite</p>
                    <?php endif; ?>
                    <input type="hidden" name="subject_id" value="<?= $subj['id'] ?>">
                    <button type="submit" name="enroll" class="btn btn-primary w-100">Enroll</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>

    <h4>My Enrollments</h4>
    <table class="table table-striped table-bordered mt-3">
        <thead class="table-primary">
            <tr>
                <th>Subject</th>
                <th>Status</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php while($enr = $enrollments->fetch_assoc()): ?>
                <tr>
                    <td><?= $enr['title'] ?></td>
                    <td><?= ucfirst($enr['status']) ?></td>
                    <td><?= $enr['grade'] ?? '-' ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

