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
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $credits = $_POST['credits'];
    $lecture_hours = $_POST['lecture_hours'];
    $course_code = $_POST['course_code'];
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];

    $sql = "INSERT INTO `course` (`course_code`, `name`, `credits`, `semester`, `lecture_hours`) VALUES ('$course_code', '$name', '$credits', '$semester', '$lecture_hours')";
    $sql1 = "INSERT INTO `course_allocation` (`course_code`, `academic_year`) VALUES ('$course_code', '$academic_year')";
    $result = mysqli_query($conn, $sql);
    if($result){
        if(mysqli_query($conn, $sql1) == TRUE){
            header('location:ma_course_list.php');
        }
        //echo "Data updated successfully";
        
    }else{
        die(mysqli_error($conn));
    }


}
        ?>

    <div class="container my-5">
        <header class="d-flex justify-content-between my-3">
            <h1>Add New Course</h1>
        </header>
        <form method="post">

            <div class="form-group">
                <label>Course Name</label>
                <label><?php echo ""?></label>
            
                <input type="text" class="form-control" placeholder="Enter Course Name" name="name" autocomplete="off" required>

            </div>

            <div class="form-group">
                <label>course Code</label>
                <label><?php echo ""?></label>
                <input type="text" class="form-control" placeholder="Enter Course Code" name="course_code" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label>Academic Year</label>
                <label><?php echo ""?></label>
                <input type="text" class="form-control" placeholder="Enter Academic Year" name="academic_year" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label>Lecture Hours</label>
                <label><?php echo ""?></label>
                <input type="text" class="form-control" placeholder="Enter Number of Lecture Hours" name="lecture_hours" autocomplete="off" required>
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

            <div class="form-group">
            <label>Semester</label>
                <select class="form-control" required name="semester">
                    <option value="">Select Semester</option>
                    <option value="semester 1">Semester 1</option>
                    <option value="semester 2">Semester 2</option>
                    <option value="semester 3">Semester 3</option>
                    <option value="semester 4">Semester 4</option>
                    <option value="semester 5">Semester 5</option>
                    <option value="semester 6">Semester 6</option>
                    <option value="semester 7">Semester 7</option>
                    <option value="semester 8">Semester 8</option>
                </select>
            </div>


            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            <button class="btn btn-danger" type="button" onclick="history.back()">Go Back</button>
        </form>
    </div>

</body>

    
</body>
</html>
