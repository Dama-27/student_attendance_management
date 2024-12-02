<?php
include("../../db_connection.php");
session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lecturer Time Schedule edit</title>
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
        $id=$_GET['id'];
$sql = "SELECT * FROM `time_table` WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$row=   mysqli_fetch_assoc($result);
    $chapter = $row['chapter'];
    $date = $row['date'];
    $start_time = $row['start_time'];
    $end_time = $row['end_time'];


if(isset($_POST['submit'])){
    $chapter = $_POST['chapter'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $sql = "UPDATE `time_table` SET `chapter`='$chapter',`date`='$date',`start_time`='$start_time',`end_time`='$end_time' WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    if($result){
        //echo "Data updated successfully";
        header('location:lecturer_course_allocation.php');
    }else{
        die(mysqli_error($conn));
    }


}
        ?>

    <div class="container my-5">
        <form method="post">

            <div class="form-group">
                <label>course Code</label>
                <label><?php echo ""?></label>
                <input type="text" class="form-control" placeholder="Enter chapter" name="chapter" autocomplete="off" value=<?php echo $chapter; ?>>
            </div>

            <div class="form-group">
                <label>Date</label>
                <input type="text" class="form-control" placeholder="Enter date(20xx-xx-xx format)" name="date" autocomplete="off" value=<?php echo $date; ?>>
            </div>

            <div class="form-group">
                <label>Start Time</label>
                <select class="form-control" name="start_time">
                <option value="8.00 am">8:00 am</option>
                <option value="9.00 am">9:00 am</option>
                <option value="10.00 am">10:00 am</option>
                <option value="11.00 am">11:00 am</option>
                <option value="12.00 pm">12:00 pm</option>
                <option value="1.00 pm">1:00 pm</option>
                <option value="2.00 pm">2:00 pm</option>
                <option value="3.00 pm">3:00 pm</option>
                </select>
            </div>

            <div class="form-group">
                <label>End Time</label>
                <select class="form-control" name="end_time">
                <option value="9.00 am">9:00 am</option>
                <option value="10.00 am">10:00 am</option>
                <option value="11.00 am">11:00 am</option>
                <option value="12.00 pm">12:00 pm</option>
                <option value="1.00 pm">1:00 pm</option>
                <option value="2.00 pm">2:00 pm</option>
                <option value="3.00 pm">3:00 pm</option>
                <option value="4.00 pm">4:00 pm</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Edit</button>
        </form>
    </div>

</body>

    
</body>
</html>
