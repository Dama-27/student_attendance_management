<?php
include("../../db_connection.php");
session_start()

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Lecturer Course Allocation</title>

	<link rel="stylesheet" type="text/css" href="../lecturer.css">

	
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

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
        
            if (isset($_GET['AcademicYear']) && $_GET['AcademicYear'] != '' && isset($_GET['Semester']) && $_GET['Semester'] != '') {
                    $AcademicYear = $_GET['AcademicYear'];
                    $Semester = $_GET['Semester'];
                    $sql = "SELECT DISTINCT
                            ca.*, 
                            c.*, 
                            l.*, 
                            s.batch,
                            l.fname AS lecturer_fname, 
                            l.lname AS lecturer_lname 
                            FROM course_allocation ca
                            JOIN course c ON c.course_code = ca.course_code
                            JOIN lecturer l ON ca.lecturer_id = l.lecturer_id
                            JOIN student s ON ca.academic_year = s.academic_year
                            WHERE ca.academic_year = '$AcademicYear' AND c.semester = '$Semester'";
                    $result = $conn->query($sql);
            } else {
                $sql = "SELECT DISTINCT
                        ca.*, 
                        c.*, 
                        l.*,
                        s.batch,
                        l.fname AS lecturer_fname, 
                        l.lname AS lecturer_lname 
                        FROM course_allocation ca
                        JOIN course c ON c.course_code = ca.course_code
                        JOIN lecturer l ON ca.lecturer_id = l.lecturer_id
                        JOIN student s ON ca.academic_year = s.academic_year";

                    $result = $conn->query($sql);
            }

            if (!$result) {
                die("Invalid Query: " . $conn->error);
            }

    ?>
    <div class="container my-5">
    <header class="d-flex justify-content-between my-3">
        <h1>Course Allocation</h1>
    </header>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                    <form action="" method="GET">
                        <div class="row">
                            
                            <div class="col-md-2">
                                <select name="AcademicYear" required class="form-select">
                                <option value="">Select Academic Year</option>
                                <?php
                                $acyear = mysqli_query($conn, "SELECT DISTINCT academic_year FROM course_allocation");
                                while ($row = mysqli_fetch_array($acyear)) {
                                    $selected = isset($_GET['AcademicYear']) && $_GET['AcademicYear'] == $row['academic_year'] ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $row['academic_year'] ?>" <?= $selected ?>><?php echo $row['academic_year'] ?></option>
                                <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select name="Semester" required class="form-select">
                                    <option value="">Select Semester</option>
                                <?php
                                $sem = mysqli_query($conn, "SELECT DISTINCT semester FROM course");
                                while ($row = mysqli_fetch_array($sem)) {
                                    $selected = isset($_GET['Semester']) && $_GET['Semester'] == $row['semester'] ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $row['semester'] ?>" <?= $selected ?>><?php echo $row['semester'] ?></option>
                                <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="lecturer_course_allocation.php" class="btn btn-danger">Reset</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <table class="table">
        <thead>
        <tr>
            <th>Course</th>
            <th>Course Code</th>
            <th>Lecturer</th>
            <th>Batch</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = $result->fetch_assoc()) {
        ?>
            <tr>    
                <td><?php echo $row['name'];?></td>                      
                <td><?php echo $row['course_code'];?></td>
                <td><?php echo $row['lecturer_fname'] . ' ' . $row['lecturer_lname'] ;?></td>                    
                
                
                
                <td>
                    <a href="lecturer_view_students.php?Batch=<?php echo $row["batch"];?>" class="btn btn-outline-dark"><?php echo $row['batch'];?></a>
                </td>
            </tr>
        <?php
        }
        ?>

        </tbody>
    </table>
</div>


</body>
</html>