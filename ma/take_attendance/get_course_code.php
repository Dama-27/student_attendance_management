<?php
include("../../db_connection.php");

if (isset($_GET['semester']) && isset($_GET['academic_year'])) {
    $semester = $_GET['semester'];
    $academic_year = $_GET['academic_year'];

    // Prepare the statement
    $stmt = $conn->prepare("SELECT DISTINCT course.course_code FROM course JOIN course_allocation ca ON ca.course_code = course.course_code WHERE ca.academic_year = ? AND course.semester = ?");
    $stmt->bind_param("ss", $academic_year, $semester);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<option value=''>Select Course Code</option>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['course_code']}'>{$row['course_code']}</option>";
    }

    // Close the statement
    $stmt->close();
}
?>