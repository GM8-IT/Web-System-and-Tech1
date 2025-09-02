<?php 
$score = $_GET['score'];
$name = $_GET['name'];

if($score >= 101){
    $grade = "Invalid";
}else if($score >= 95){
    $grade = "A";
}else if($score >= 90){
    $grade = "B";
}else if($score >= 85){
    $grade = "C";
}else if($score >= 75 ){
    $grade = "D";
}else if($score <= 74){
    $grade = "F";
}else{
    $grade = "Invalid output";
}

switch($grade){
    case 'A':
        $remarks = "Outstanding Performance!";
    break;
    case 'B':
        $remarks = "Great Job!";
    break;
    case 'C':
        $remarks = "Good effort, keep it up!";
    break;
    case 'D':
        $remarks = "Work harder next time.";
    break;
    case 'F':
        $remarks = "You need to improve.";
    break;
    case 'Invalid':
        $remarks = "N/A";
    break;
    case 'default':
        $remarks = "N/A";
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .card {
            width: 300px;
            padding: 15px;
            margin: 50px auto;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-family: sans-serif;
            background: #f9f9f9;
        }
        .card h2 {
            text-align: center;
        }
        .card p {
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Student Remarks</h2>
        <p><strong>Name:</strong> <?php echo $name; ?></p>
        <p><strong>Score:</strong> <?php echo $score; ?></p>
        <p><strong>Grade:</strong> <?php echo $grade; ?></p>
        <p><strong>Remarks:</strong> <?php echo $remarks; ?></p>
    </div>
</body>
</html>