<?php
include("../../db_connection.php");

if (isset($_GET['academic_year'])) {
    $academic_year = $_GET['academic_year'];
    $result = mysqli_query($conn, "SELECT DISTINCT semester FROM course JOIN course_allocation ca ON ca.course_code = course.course_code WHERE ca.academic_year = '$academic_year'");

    echo "<option value=''>Select Semester</option>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<option value='{$row['semester']}'>{$row['semester']}</option>";
    }
}
?>