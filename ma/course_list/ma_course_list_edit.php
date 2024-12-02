<?php

include("../../db_connection.php");
session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MA Course List edit</title>
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
			<li>
				<a href="../mahome.php">Dashboard</a>
			</li>
			<li>
				<a href="ma_course_list.php">Course List</a>
			</li>
			<li>
				<a href="../Student_list/ma_student_list.php">Student List</a>
			</li>
			<li>
				<a href="../lecturer_list/ma_lecturer_list.php">Lecturer List</a>
			</li>
			<li>
				<a href="../course_allocation/ma_course_allocation.php">Course Allocation</a>
			</li>
			<li>
				<a href="../take_attendance/ma_take_attendance.php">Take Attendance</a>
			</li>
			<li>
				<a href="../ma_report.php">Reports</a>
			</li>
			<li>
				<a href="../../login/reset_password.php">Reset Password</a>
			</li>
		</ul>
	</aside>
    <?php
    $username = $_SESSION['username'];
    ?>

    <div class="content">
        <?php
        //include("db_connection.php");
        $old_course_code=$_GET['course_code'];
        $sql = "SELECT *
        FROM course c
        JOIN course_allocation ca ON c.course_code = ca.course_code
        WHERE c.course_code = '$old_course_code'";
        
        $result = $conn->query($sql);  
        $result = mysqli_query($conn, $sql);
        $row=   mysqli_fetch_assoc($result);

        $name = $row['name'];
        $credits = $row['credits'];
        $lecture_hours = $row['lecture_hours'];


    


if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $credits = $_POST['credits'];
    $lecture_hours = $_POST['lecture_hours'];
    $course_code = $_POST['course_code'];

    $sql = "UPDATE `course` SET `course_code`='$course_code',`name`='$name',`credits`='$credits',`lecture_hours`='$lecture_hours' WHERE course_code='$old_course_code'";
   
    $result = mysqli_query($conn, $sql);
   
    if($result){
        header('location:ma_course_list.php');
    
    }else{
        die(mysqli_error($conn));
    }
}
        ?>

    <div class="container my-5">
        <form method="post">
            <header class="d-flex justify-content-between my-3">
                <h1>Course List Edit</h1>
            </header>
            <div class="form-group">
                <label>Course Name</label>
                <label><?php echo ""?></label>
                <input type="text" class="form-control" placeholder="Enter Course Name" name="name" autocomplete="off" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>" required>

            </div>

            <div class="form-group">
                <label>course Code</label>
                <label><?php echo ""?></label>
                <input type="text" class="form-control" placeholder="Enter Course Code" name="course_code" autocomplete="off" value=<?php echo $old_course_code; ?> required>
            </div>

            <div class="form-group">
                <label>Lecture Hours</label>
                <label><?php echo ""?></label>
                <input type="text" class="form-control" placeholder="Enter Number of Lecture Hours" name="lecture_hours" autocomplete="off" value=<?php echo $lecture_hours; ?> required>
            </div>

            <div class="form-group">
                <label>Credits</label>
                <select class="form-control" required name="credits">
                <option value="">Select Credits</option>
                <option value=1>1</option>
                <option value=2>2</option>
                <option value=3>3</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Edit</button>
            <button class="btn btn-danger" type="button" onclick="history.back()">Go Back</button>
        </form>
    </div>

</body>

    
</body>
</html>
