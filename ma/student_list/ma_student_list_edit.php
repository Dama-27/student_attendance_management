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
    <title>MA Student Add</title>
    <link rel="stylesheet" type="text/css" href="../ma.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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
        <li><a href="ma_student_list.php">Student List</a></li>
        <li><a href="../lecturer_list/ma_lecturer_list.php">Lecturer List</a></li>
        <li><a href="../course_allocation/ma_course_allocation.php">Course Allocation</a></li>
        <li><a href="../take_attendance/ma_take_attendance.php">Take Attendance</a></li>
        <li><a href="../ma_report.php">Reports</a></li>
        <li><a href="../../login/reset_password.php">Reset Password</a></li>
    </ul>
</aside>

<div class="content">
    <?php
    $email_old = $_GET['email'];
    if (isset($_POST['submit'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $reg_no = $_POST['reg_no'];
        $academic_year = $_POST['academic_year'];
        $batch = $_POST['batch'];
        $email = $_POST['email'];
    
        try {
            // Start transaction
            $conn->begin_transaction();
    
            $sql1 = "UPDATE student SET fname = ?, lname = ?, reg_no = ?, academic_year = ?, batch = ?, email = ? WHERE email = ?";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("sssssss", $fname, $lname, $reg_no, $academic_year, $batch, $email, $email_old);
    
            if (!$stmt1->execute()) {
                throw new Exception("Error updating student table: " . $stmt1->error);
            }
    
            // Commit transaction
            $conn->commit();
            header('Location: ma_student_list.php');
        } catch (Exception $e) {
            // Rollback transaction
            $conn->rollback();
            die("Transaction failed: " . $e->getMessage());
        }
    }
    ?>
<?php
$sql_get = "SELECT * FROM student WHERE email = '$email_old'";
$result = mysqli_query($conn, $sql_get);
$row=   mysqli_fetch_assoc($result);
?>
    <div class="container my-5">
        <header class="d-flex justify-content-between my-3">
            <h1>Add New Student</h1>
        </header>
        <form method="post">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" placeholder="Enter First Name" name="fname" autocomplete="off" value="<?php echo htmlspecialchars($row['fname'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label>Second Name</label>
                <input type="text" class="form-control" placeholder="Enter Last Name" name="lname" autocomplete="off" value="<?php echo htmlspecialchars($row['lname'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label>Registration NO</label>
                <input type="text" class="form-control" placeholder="Enter Registartion NO" name="reg_no" autocomplete="off" value="<?php echo htmlspecialchars($row['reg_no'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label>Academic Year</label>
                <input type="text" class="form-control" placeholder="Enter Academic Year" name="academic_year" autocomplete="off" value="<?php echo htmlspecialchars($row['academic_year'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label>Batch</label>
                <input type="text" class="form-control" placeholder="Enter Batch" name="batch" autocomplete="off" value="<?php echo htmlspecialchars($row['batch'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="text" class="form-control" placeholder="Enter Email Address" name="email" autocomplete="off" value="<?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            <button class="btn btn-danger" type="button" onclick="history.back()">Go Back</button>
        </form>
    </div>
</div>

</body>
</html>