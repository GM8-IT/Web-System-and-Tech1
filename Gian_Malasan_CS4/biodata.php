<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<div style='width:800px;margin:auto;font-family:Arial'>";
    echo "<h1>BIO-DATA</h1>";

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target = "uploads/" . basename($_FILES["photo"]["name"]);
        if (!is_dir("uploads")) {
            mkdir("uploads");
        }
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target);
        echo "<div style='float:right'><img src='$target' width='100' height='100'></div>";
    }

    foreach ($_POST as $key => $value) {
        if (!empty($value)) {
            echo "<p><strong>" . ucfirst(str_replace("_"," ",$key)) . ":</strong> " . htmlspecialchars($value) . "</p>";
        }
    }

    echo "</div>";
}
?>
