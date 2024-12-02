<?php
include("../../db_connection.php");
session_start();


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lecturer view students</title>
    <link rel="stylesheet" type="text/css" href="../ma.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
</head>
<body>
<header class="header">
        <a href="../lecturerhome.php">Lecturer Dashboard</a>
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
				<a href="../course_list/ma_course_list.php">Course List</a>
			</li>
			<li>
				<a href="../student_list/ma_student_list.php">Student List</a>
			</li>
			<li>
				<a href="../lecturer_list/ma_lecturer_list.php">Lecturer List</a>
			</li>
			<li>
				<a href="ma_course_allocation.php">Course Allocation</a>
			</li>
			<li>
				<a href="../ma_take_attendance.php">Take Attendance</a>
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
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $batch = $_GET['Batch'];
            $sql = "SELECT reg_no, lname, fname, batch
                    FROM student WHERE batch = '$batch'";
            
            $result = $conn->query($sql);

        }


        if (!$result) {
            die("Invalid Query: " . $conn->error);
        }
        ?>
<div class="container my-5">
    <header class="d-flex justify-content-between my-3">
        <?php $batch = $_GET['Batch']; ?>
        <h1>View Students in <?php echo "{$batch}"?> Batch</h1>
    </header>
    </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Reg NO</th>
                        <th>Name</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $row['reg_no']; ?></td>
                            <td><?php echo $row['fname'] . ' ' . $row['lname']; ?></td>

                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <table class="table table-bordered">

            <a href="ma_course_allocation.php" class="btn btn-danger">Back</a>

</body>
</html>
