<?php
include("../../db_connection.php");
session_start();
$username = $_SESSION['username'];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MA Lecturer List</title>
    <link rel="stylesheet" type="text/css" href="../ma.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>

	<header class="header">
		
		<a href="mahome.php">MA Dashboard</a>

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

<div class="content">
<?php

                    $sql = "SELECT l.*, lc.*
                    FROM lecturer l
                    LEFT JOIN lecturer_course lc ON l.lecturer_id = lc.lecturer_id";

                    // $sql = "SELECT DISTINCT l.*
                    // FROM lecturer l";

                    $result = $conn->query($sql);
            // }

            if (!$result) {
                die("Invalid Query: " . $conn->error);
            }

    ?>
    <div class="container my-5">
    <header class="d-flex justify-content-between my-3">
        <h1>Lecturers</h1>
    </header>
    <br>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Lecturering Course Code</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = $result->fetch_assoc()) {
        ?>
            <tr>    
                <td><?php echo $row['fname'] . ' ' . $row['lname'] ;?></td>                   
                <td>
                    <?php 
                    echo isset($row['course_code']) ? $row['course_code'] : "NA";
                    ?>
                </td>

                <td><?php echo $row['email'];?></td>                      
                <td>
                    <a href="ma_lecturer_list_edit.php?lecturer_id=<?php echo $row["lecturer_id"];?>" class="btn btn-primary">edit</a>
                    <a href="ma_lecturer_list_delete.php?lecturer_id=<?php echo $row["lecturer_id"];?>" class="btn btn-danger">delete</a>

                </td>                     
            </tr>
        <?php
        }
        ?>

        </tbody>
    </table>
    <div class="col-md-4">
        <a href="ma_lecturer_list_create.php" class ="btn btn-primary">Add Lecturer</a>
    </div>
</div>


</body>
</html>