<!DOCTYPE html>
<html>
<head>
    <title>Resume</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .header {
            display: flex;
            background-color: #007acc;
            color: white;
        }
        .header-left {
            width: 25%;
            text-align: center;
        }
        .header-left img {
            width: 130px;
            height: 160px;
        }
        .header-right {
            width: 75%;
            padding-left: 20px;
        }
        .header-right h1 {
            margin: 0;
            font-size: 28px;
        }
        .header-right h2 {
            margin: 0;
            font-size: 18px;
            font-weight: normal;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            margin-top: 12px;
            font-size: 14px;
            line-height: 1.5em;
        }
        .section {
            margin: 20px;
        }
        .section h3 {
            color: #007acc;
            font-size: 18px;
            border-bottom: 2px solid #000;
            padding-bottom: 3px;
            margin-bottom: 12px;
        }
        .entry {
            display: grid;
            grid-template-columns: 150px auto;
            margin-bottom: 15px;
        }
        .entry b {
            display: block;
        }
        ul {
            margin: 5px 0 5px 20px;
        }
    </style>
</head>
<body>

<?php
$name = "Gian L. Malasan";
$role = "IT Student";
$phone = "09761842173";
$email = "23ur0627@psu.edu.ph";
$linkedin = "www.linkedin.com/in/gian-malasan-199a07349";
$gitlab = "gitlab.com/GM8-IT";
$address = "Primicias, Santa Barbara, Pangasinan";
$dob = "08 May 2005";
$gender = "Male";
$nationality = "Filipino";

$summary = "An Information Technology student from Pangasinan State University,
 skilled in technology and digital solutions, with a strong interest in programming, system development, and problem-solving.
 Dedicated to continuous learning and applying IT knowledge to real-world challenges.";

$highSchool = "Daniel Maramba National High School";
$highSchoolYear = "2017 - 2023";
$highSchoolGrade = "CBSE: N/A";

$college = "Pangasinan State Unversity - Urdaneta City Campus";
$collegeYear = "2023 - Present";
$collegeDegree = "Bachelor of Science in Information Technology";
$collegeGrade = "CGPA: N/A";
$specialization = "Designing and Implementing System Software";

$jobTitle = "N/A";
$company = "N/A";
$jobYear = "N/A";
$exp1 = "N/A";
$exp2 = "N/A";
$exp3 = "N/A";

$skill1 = "Java";
$skill2 = "HTML";
$skill3 = "CSS";
$skill4 = "JavaScript";
?>

<div class="header">
    <div class="header-left">
        <img src="grad pic.jpg" alt="Profile Picture">
    </div>
    <div class="header-right">
        <h1><?php echo $name; ?></h1>
        <h2><?php echo $role; ?></h2>

        <div class="info-grid">
            <div>
                <b>Phone:</b> <?php echo $phone; ?><br>
                <b>Email:</b> <?php echo $email; ?><br>
                <b>LinkedIn:</b> <?php echo $linkedin; ?><br>
                <b>GitLab:</b> <?php echo $gitlab; ?>
            </div>
            <div>
                <b>Address:</b> <?php echo $address; ?><br>
                <b>Date of birth:</b> <?php echo $dob; ?><br>
                <b>Gender:</b> <?php echo $gender; ?><br>
                <b>Nationality:</b> <?php echo $nationality; ?>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <p><b><?php echo $summary; ?></b></p>
</div>

<div class="section">
    <h3>Education</h3>

    <div class="entry">
        <div><b><?php echo $highSchoolYear; ?></b></div>
        <div>
            <b>High School Diploma</b><br>
            <?php echo $highSchool; ?><br>
            <?php echo $highSchoolGrade; ?><br><br>
            <b>Activities:</b>
            <ul>
                <li>N/A</li>
                <li>N/A</li>
            </ul>
        </div>
    </div>

    <div class="entry">
        <div><b><?php echo $collegeYear; ?></b></div>
        <div>
            <b><?php echo $collegeDegree; ?></b><br>
            <?php echo $college; ?><br>
            <?php echo $collegeGrade; ?><br><br>
            <b>Specialization:</b> <?php echo $specialization; ?>
        </div>
    </div>
</div>

<div class="section">
    <h3>Experience</h3>

    <div class="entry">
        <div><b><?php echo $jobYear; ?></b></div>
        <div>
            <b><?php echo $jobTitle; ?></b><br>
            <?php echo $company; ?><br>
            <ul>
                <li><?php echo $exp1; ?></li>
                <li><?php echo $exp2; ?></li>
                <li><?php echo $exp3; ?></li>
            </ul>
        </div>
    </div>
</div>

<div class="section">
    <h3>Skills</h3>
    <ul>
        <li><?php echo $skill1; ?></li>
        <li><?php echo $skill2; ?></li>
        <li><?php echo $skill3; ?></li>
        <li><?php echo $skill4; ?></li>
    </ul>
</div>

</body>
</html>
