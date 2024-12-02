<?php
include("../../db_connection.php");
session_start();

// Ensure user is authenticated
if (!isset($_SESSION['username'])) {
    header('Location: ../../login/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MA Lecturer Add</title>
    <link rel="stylesheet" type="text/css" href="../ma.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
</head>
<body>
<header class="header">
    <a href="../mahome.php">Lecturer Dashboard</a>
    <div class="logout">
        <a href="../../login/logout.php" class="btn btn-primary">Logout</a>
    </div>
</header>
<aside>  
    <ul>  
        <li><a href="../mahome.php">Dashboard</a></li>
        <li><a href="../course_list/ma_course_list.php">Course List</a></li>
        <li><a href="../student_list/ma_student_list.php">Student List</a></li>
        <li><a href="ma_lecturer_list.php">Lecturer List</a></li>
        <li><a href="../course_allocation/ma_course_allocation.php">Course Allocation</a></li>
        <li><a href="../take_attendance/ma_take_attendance.php">Take Attendance</a></li>
        <li><a href="../ma_report.php">Reports</a></li>
        <li><a href="../../login/reset_password.php">Reset Password</a></li>
    </ul>
</aside>
<?php
$username = $_SESSION['username'];
?>

<div class="content">
    <?php
    if (isset($_POST['submit'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $course_code = $_POST['course_code'];
        $email = $_POST['email'];

        try {
            // Insert into lecturer table
            $sql1 = "INSERT INTO lecturer (fname, lname, email) VALUES (?, ?, ?)";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("sss", $fname, $lname, $email);
        
            if (!$stmt1->execute()) {
                throw new Exception("Error inserting into lecturer table: " . $stmt1->error);
            }
        
            // Get the last inserted lecturer_id
            $lecturer_id = $conn->insert_id;
        
            // Insert into lecturer_course table
            $sql2 = "INSERT INTO lecturer_course (lecturer_id, course_code) VALUES (?, ?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("is", $lecturer_id, $course_code);
        
            if (!$stmt2->execute()) {
                throw new Exception("Error inserting into lecturer_course table: " . $stmt2->error);
            }
        
            // Commit transaction
            $conn->commit();
            header('Location: ma_lecturer_list.php');
        } catch (Exception $e) {
            // Rollback transaction
            $conn->rollback();
            die("Transaction failed: " . $e->getMessage());
        }
    }
    ?>

    <div class="container my-5">
        <header class="d-flex justify-content-between my-3">
            <h1>Add New Lecturer</h1>
        </header>
        <form method="post">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" placeholder="Enter First Name" name="fname" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label>Second Name</label>
                <input type="text" class="form-control" placeholder="Enter Second Name" name="lname" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label>Course Code</label>
                <input type="text" class="form-control" placeholder="Enter Course Code" name="course_code" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" class="form-control" placeholder="Enter Email" name="email" autocomplete="off" required>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            <button class="btn btn-danger" type="button" onclick="history.back()">Go Back</button>
        </form>
    </div>
</div>

</body>
</html>
