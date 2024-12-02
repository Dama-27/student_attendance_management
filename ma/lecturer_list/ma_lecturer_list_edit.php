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
    <title>MA Lecturer List Edit</title>
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
    $lecturer_id = $_GET['lecturer_id'];

    $sql = "SELECT l.*, lc.* FROM lecturer l INNER JOIN lecturer_course lc ON l.lecturer_id = lc.lecturer_id WHERE l.lecturer_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lecturer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $fname = $row['fname'];
    $lname = $row['lname'];
    $course_code = $row['course_code'];
    $email = $row['email'];

    if (isset($_POST['submit'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $course_code = $_POST['course_code'];
        $email = $_POST['email'];

        // Update the lecturer details
        
$conn->begin_transaction();

try {
    // Update lecturer table
    $sql1 = "UPDATE lecturer SET fname = ?, lname = ?, email = ? WHERE lecturer_id = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("sssi", $fname, $lname, $email, $lecturer_id);
    $result1 = $stmt1->execute();

    if (!$result1) {
        throw new Exception("Error updating lecturer table: " . $stmt1->error);
    }

    // Update lecturer_course table
    $sql2 = "UPDATE lecturer_course SET course_code = ? WHERE lecturer_id = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("si", $course_code, $lecturer_id);
    $result2 = $stmt2->execute();

    if (!$result2) {
        throw new Exception("Error updating lecturer_course table: " . $stmt2->error);
    }

    // Commit transaction
    $conn->commit();
    header('Location: ma_lecturer_list.php');
} catch (Exception $e) {
    // Rollback transaction
    $conn->rollback();
    die("Transaction failed: " . $e->getMessage());
}

$conn->close();


    }
    ?>

    <div class="container my-5">
        <form method="post">
            <header class="d-flex justify-content-between my-3">
                <h1>Lecturer Editing</h1>
            </header>
            <div class="form-group">
                <label>First Name Of The Lecturer</label>
                <input type="text" class="form-control" placeholder="Enter first name" name="fname" autocomplete="off" value="<?php echo htmlspecialchars($fname, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label>Second Name Of The Lecturer</label>
                <input type="text" class="form-control" placeholder="Enter second name" name="lname" autocomplete="off" value="<?php echo htmlspecialchars($lname, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label>Course Code</label>
                <input type="text" class="form-control" placeholder="Enter Course Code" name="course_code" autocomplete="off" value="<?php echo htmlspecialchars($course_code, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" placeholder="Enter Email" name="email" autocomplete="off" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Edit</button>
            <button class="btn btn-danger" type="button" onclick="history.back()">Go Back</button>
        </form>
    </div>
</div>

</body>
</html>
