<?php
include("../../db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_code = $_POST['course_code'];
    $date = $_POST['date'];
    // $start_time = $_POST['start_time'];
    // $end_time = $_POST['end_time'];
    $time = $_POST['time'];

    if (isset($_POST['students']) && is_array($_POST['students'])) {
        foreach ($_POST['students'] as $student_id => $present) {
            $present = $present ? 'yes' : 'no';
            $query = "UPDATE attendance SET present = '$present' WHERE id = '$student_id' AND course_code = '$course_code' AND date = '$date' AND time = '$time'";
            mysqli_query($conn, $query);
        }
        echo "Attendance saved successfully.";
    } else {
        echo "No student attendance data received.";
    }
}
?>