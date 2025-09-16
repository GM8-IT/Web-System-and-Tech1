
<?php
$row = $_POST['row'];
$row_int = (int)$row;

$col = $_POST['col'];
$col_int = (int)$col;

echo "<h2>Multiplication Table - Rows:$row_int Columns:$col_int</h2>";
echo "<table border='1' style='text-align:center'>";

echo "<tr><th>X</th>";
for ($k = 1; $k <= $col; $k++) {
    echo "<th>$k</th>";
}
echo "</tr>";

for($i=1; $i <= $row_int; $i++){
    echo "<tr>";
    echo "<th>$i</th>";
    for($j=1; $j <= $col_int; $j++){
        $result = $i * $j;
        if($result % 2 != 0){
            echo "<td style='background-color:yellow'><b>$result</b></td>";
        }else{
            echo "<td>$result</td>";
        }
    }
    echo "</tr>";
}
    echo "</table>";
?>