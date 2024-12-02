<?php
include("../../db_connection.php");
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MA Course Allocation Edit</title>
    <link rel="stylesheet" type="text/css" href="../ma.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .content {
            margin-left: 220px; 
            padding: 20px;
        }
    </style>
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
        <li><a href="../student_list/ma_student_list.php">Student List</a></li>
        <li><a href="../lecturer_list/ma_lecturer_list.php">Lecturer List</a></li>
        <li><a href="ma_course_allocation.php">Course Allocation</a></li>
        <li><a href="../take_attendance/ma_take_attendance.php">Take Attendance</a></li>
        <li><a href="../ma_report.php">Reports</a></li>
        <li><a href="../../login/reset_password.php">Reset Password</a></li>
    </ul>
</aside>

<?php
$username = $_SESSION['username'];
$course_code = $_GET['course_code'];

$sql = "SELECT * FROM course_allocation ca JOIN course c ON c.course_code = ca.course_code WHERE c.course_code = '$course_code'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$name = $row['name'];
$old_academic_year = $row['academic_year'];
$semester = $row['semester'];
$lecturer_id = $_GET['lecturer_id'];

if(isset($_POST['submit'])){
    $batch = $_POST['batch'];
    $course_code = $_POST['course_code'];
    
    $sql = "SELECT academic_year FROM student WHERE batch = '$batch'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $academic_year = $row['academic_year'];
    
    $sql = "UPDATE `course_allocation` SET `academic_year`='$academic_year' WHERE course_code='$course_code'";
    $sql1 = "UPDATE `lecturer_course` SET `course_code`='$course_code' WHERE `lecturer_id`='$lecturer_id'";
    $result = mysqli_query($conn, $sql);
    
    if($result){
        if(mysqli_query($conn, $sql1) == TRUE){
            header('location:ma_course_allocation.php');
        }
    } else {
        die(mysqli_error($conn));
    }
}
?>

<div class="content">
    <div class="container my-5">
        <form method="post">
            <header class="d-flex justify-content-between my-3">
                <h1>Course Allocation Edit</h1>
            </header>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Academic Year</label>
                        <input type="text" class="form-control" placeholder="Academic year" name="academic_year" autocomplete="off" value="<?php echo $old_academic_year; ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Semester</label>
                        <input type="text" class="form-control" placeholder="Semester" name="semester" autocomplete="off" value="<?php echo $semester; ?>" readonly>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Lecturer</label>
                        <?php
                        $lect = mysqli_query($conn, "SELECT fname, lname FROM lecturer WHERE lecturer_id='$lecturer_id'");

                        $row = mysqli_fetch_array($lect);
                        ?>
                        <input type="text" class="form-control" placeholder="Lecturer" name="lecturer_name" autocomplete="off" value="<?php echo $row['fname'] . ' ' . $row['lname']; ?>" readonly>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Course Code</label>
                        <select name="course_code" required class="form-control">
                            <option value="">Select Course Code</option>
                            <?php
                            $course = mysqli_query($conn, "SELECT DISTINCT c.course_code FROM course c, course_allocation ca WHERE ca.academic_year = '$old_academic_year' AND c.semester = '$semester'");
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
            <button type="submit" class="btn btn-primary" name="submit">Edit</button>
            <button class="btn btn-danger" type="button" onclick="history.back()">Go Back</button>
        </form>
    </div>
</div>
</body>
</html>
