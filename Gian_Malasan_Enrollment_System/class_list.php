<?php
include 'header.php';
include 'db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'faculty'){
    header("Location: login.php");
    exit;
}

if(isset($_POST['submit_grade'])){
    $enrollment_id = $_POST['enrollment_id'];
    $grade = $_POST['grade'];
    $status = $grade ? 'completed' : 'enrolled';
    $conn->query("UPDATE enrollments SET grade='$grade', status='$status' WHERE id=$enrollment_id");
}

$enrollments = $conn->query("
    SELECT e.id as enroll_id, u.full_name, u.profile_pic, u.signature_img, s.title, e.grade, e.status 
    FROM enrollments e 
    JOIN users u ON e.student_id=u.id
    JOIN subjects s ON e.subject_id=s.id
    ORDER BY s.title, u.full_name
");
?>

<div class="card p-4 mt-4">
    <h3 class="mb-4">Class Lists</h3>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-primary">
            <tr>
                <th>Student</th>
                <th>Profile</th>
                <th>Signature</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Grade</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $enrollments->fetch_assoc()): ?>
            <tr>
                <td><?= $row['full_name'] ?></td>
                <td>
                    <?php if($row['profile_pic']): ?>
                        <img src="uploads/<?= $row['profile_pic'] ?>" class="profile rounded-circle" width="50" height="50">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($row['signature_img']): ?>
                        <img src="uploads/<?= $row['signature_img'] ?>" class="signature" width="80" height="50">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td><?= $row['title'] ?></td>
                <td><?= ucfirst($row['status']) ?></td>
                <td><?= $row['grade'] ?? '-' ?></td>
                <td>
                    <form method="post" class="d-flex gap-1">
                        <input type="hidden" name="enrollment_id" value="<?= $row['enroll_id'] ?>">
                        <input type="text" name="grade" class="form-control form-control-sm" placeholder="Grade" value="<?= $row['grade'] ?>">
                        <button type="submit" name="submit_grade" class="btn btn-primary btn-sm">Submit</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

