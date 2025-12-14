<?php
include 'header.php';
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
?>
<div class="wrapper">
    <div class="content">
<div class="text-center my-5">
    <h3>Welcome, <?= $_SESSION['full_name'] ?> (<?= ucfirst($_SESSION['role']) ?>)</h3>
</div>

<div class="cards-grid my-4">
    <?php if($_SESSION['role'] == 'admin'): ?>
        <a href="manage_users.php" class="btn btn-primary btn-lg p-4">Manage Users</a>
        <a href="manage_subjects.php" class="btn btn-secondary btn-lg p-4">Manage Subjects</a>
    <?php elseif($_SESSION['role'] == 'faculty'): ?>
        <a href="class_list.php" class="btn btn-primary btn-lg p-4">View Class Lists</a>
    <?php elseif($_SESSION['role'] == 'student'): ?>
        <a href="enroll_subject.php" class="btn btn-primary btn-lg p-4">Enroll Subjects</a>
    <?php endif; ?>
</div>
    </div>
    </div>

