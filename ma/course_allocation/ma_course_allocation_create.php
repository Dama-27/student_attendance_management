<?php
include("../../db_connection.php");
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../../login/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MA Course Allocation Add</title>
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
        <li><a href="../ma_lecturer_list.php">Lecturer List</a></li>
        <li><a href="ma_course_allocation.php">Course Allocation</a></li>
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
        $batch = $_POST['batch'];
        $course_code = $_POST['course_code'];
        $lecturer_id = $_POST['lecturer'];

        $sql = "SELECT academic_year FROM student WHERE batch = '$batch'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $academic_year = $row['academic_year'];

            // Updating course allocation and lecturer details
            $sql = "INSERT INTO `course_allocation`(`course_code`, `academic_year`) VALUES ('$course_code','$academic_year')";
            $stmt = $conn->prepare($sql);

            if ($stmt->execute()) {
                $sql = "INSERT INTO `lecturer_course`(`lecturer_id`, `course_code`) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $lecturer_id, $course_code);

                if ($stmt->execute()) {
                    header('Location: ma_course_allocation.php');
                } else {
                    die("Error: " . $stmt->error);
                }
            } else {
                die("Error: " . $stmt->error);
            }
        } else {
            die("Error fetching academic year: " . mysqli_error($conn));
        }
    }
    ?>

    <div class="container my-5">
        <header class="d-flex justify-content-between my-3">
            <h1>Add New Course Allocation</h1>
        </header>
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Lecturer</label>
                        <select name="lecturer" required class="form-control">
                            <option value="">Select Lecturer</option>
                            <?php

                            $lect = mysqli_query($conn, "SELECT lecturer_id, fname, lname FROM lecturer");
                            while ($row = mysqli_fetch_array($lect)) {
                                $selected = isset($_GET['lecturer']) && $_GET['lecturer'] == $row['lecturer_id'] ? 'selected' : '';
                                echo "<option value='{$row['lecturer_id']}' {$selected}>{$row['fname']} {$row['lname']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Course Code</label>
                        <select name="course_code" required class="form-control">
                            <option value="">Select Course Code</option>
                            <?php
                            // Fetching course codes
                            $course = mysqli_query($conn, "SELECT DISTINCT course_code FROM course");
                            while ($row = mysqli_fetch_array($course)) {
                                $selected = isset($_GET['course_code']) && $_GET['course_code'] == $row['course_code'] ? 'selected' : '';
                                echo "<option value='{$row['course_code']}' {$selected}>{$row['course_code']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Batch</label>
                        <select name="batch" required class="form-control">
                            <option value="">Select Batch</option>
                            <?php
                            // Fetching distinct batches
                            $bat = mysqli_query($conn, "SELECT DISTINCT batch FROM student");
                            while ($row = mysqli_fetch_array($bat)) {
                                $selected = isset($_GET['batch']) && $_GET['batch'] == $row['batch'] ? 'selected' : '';
                                echo "<option value='{$row['batch']}' {$selected}>{$row['batch']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            <button class="btn btn-danger" type="button" onclick="history.back()">Go Back</button>
        </form>
    </div>
</div>

</body>
</html>
