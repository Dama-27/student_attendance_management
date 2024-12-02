
<?php
include("../../db_connection.php");

if (isset($_GET['course_code']) && isset($_GET['date']) && isset($_GET['time'])) {
    $course_code = $_GET['course_code'];
    $date = $_GET['date'];
    // $start_time = $_GET['start_time'];
    // $end_time = $_GET['end_time'];
    $time = $_GET['time'];
    $query = "SELECT * FROM attendance WHERE course_code = '$course_code' AND date = '$date' AND time = '$time' AND status = 'Present'";
$result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_array($result)) {
        //$fullName = $row['fname'] . ' ' . $row['lname'];
        $isChecked = $row['present'] ? "checked" : "";
        echo "<tr>
                // <td>" . htmlspecialchars($row['course_code'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlspecialchars($row['reg_no'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>
                    <input type='hidden' name='students[" . intval($row['id']) . "]' value='0'>
                    <input type='checkbox' name='students[" . intval($row['id']) . "]' value='1' " . $isChecked . ">
                </td>
              </tr>";
    }
}
?>

<!-- <?php
include("../../db_connection.php");

$course_code = $_GET['course_code'];
$date = $_GET['date'];
// $start_time = $_GET['start_time'];
// $end_time = $_GET['end_time'];
$time = $_GET['time'];

$query = "SELECT * FROM attendance WHERE course_code = '$course_code' AND date = '$date' AND time = '$time' AND status = 'Present'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>{$row['reg_no']}</td>";
    echo "<td>{$row['course_code']}</td>";
    echo "<td>{$row['date']}</td>";
    echo "<td>{$row['time']}</td>";
    // echo "<td>{$row['start_time']}</td>";
    // echo "<td>{$row['end_time']}</td>";
    echo "<td>{$row['status']}</td>";
    echo "<td>{$row['present']}</td>";
    echo "</tr>";
}
?> -->