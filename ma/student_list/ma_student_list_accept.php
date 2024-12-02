<?php
include("../../db_connection.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('location: ../../login/login.php');
    exit();
}

// Ensure the email parameter is provided
if (!isset($_GET['email'])) {
    die("Email parameter is missing.");
}

$email = $_GET['email'];

// Prepare and bind
$stmt = $conn->prepare("UPDATE student SET status = 'active' WHERE email = ?");
$stmt->bind_param("s", $email);

// Execute the query
if ($stmt->execute()) {
    header('Location: ma_student_list.php');
    exit();
} else {
    die("Error updating record: " . $stmt->error);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Accept Student</title>
    <link rel="stylesheet" type="text/css" href="../ma.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</head>
<body>
    <header class="header">
        <a href="../mahome.php">MA Dashboard</a>
        <div class="logout">
            <a href="../../login/logout.php" class="btn btn-primary">Logout</a>
        </div>
    </header>
    <aside>    
        <ul>    
            <li><a href="../mahome.php">Dashboard</a></li>
            <li><a href="../course_list/ma_course_list.php">Course List</a></li>
            <li><a href="ma_student_list.php">Student List</a></li>
            <li><a href="../lecturer_list/ma_lecturer_list.php">Lecturer List</a></li>
            <li><a href="../course_allocation/ma_course_allocation.php">Course Allocation</a></li>
            <li><a href="../take_attendance/ma_take_attendance.php">Take Attendance</a></li>
            <li><a href="../ma_report.php">Reports</a></li>
            <li><a href="../../login/reset_password.php">Reset Password</a></li>
        </ul>
    </aside>
</body>
</html>