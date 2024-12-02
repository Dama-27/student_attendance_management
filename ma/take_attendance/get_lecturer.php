<?php
include("../../db_connection.php");

if (isset($_GET['course_code'])) {
    $course_code = $_GET['course_code'];
    $result = mysqli_query($conn, "SELECT DISTINCT l.lecturer_id, l.fname, l.lname 
                                   FROM lecturer l 
                                   INNER JOIN lecturer_course lc ON l.lecturer_id = lc.lecturer_id 
                                   WHERE lc.course_code = '$course_code'");

    echo "<option value=''>Select Lecturer</option>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<option value='{$row['lecturer_id']}'>{$row['fname']} {$row['lname']}</option>";
    }
}
?>