<?php
include("../../db_connection.php");
session_start();


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lecturer view students</title>
    <link rel="stylesheet" type="text/css" href="../lecturer.css">
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
				<a href="../lecturerhome.php">Dashboard</a>
			</li>
			<li>
				<a href="../lecturer_course_list.php">Course List</a>
			</li>
			<li>
				<a href="../time_schedule/lecturer_time_schedule.php">Time Schedule</a>
			</li>
			<li>
				<a href="lecturer_course_allocation.php">Course Allocation</a>
			</li>
			<li>
				<a href="">Report</a>
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

            <a href="lecturer_course_allocation.php" class="btn btn-danger">Back</a>

</body>
</html>
