<?php
include("../../db_connection.php");
session_start();


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lecturer Time Schedule</title>
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
				<a href="lecturer_time_schedule.php">Time Schedule</a>
			</li>
			<li>
				<a href="../course_allocation/lecturer_course_allocation.php">Course Allocation</a>
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
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['AcademicYear']) && $_GET['AcademicYear'] != '' && isset($_GET['Semester']) && $_GET['Semester'] != '' && isset($_GET['course_code']) && $_GET['course_code'] != '') {
            $AcademicYear = $_GET['AcademicYear'];
            $Semester = $_GET['Semester'];
            $code=$_GET['course_code'];
            $sql = "SELECT c.course_code, c.semester, ca.academic_year, ca.course_code, tt.* FROM course_allocation ca, course c, time_table tt
            WHERE c.course_code=ca.course_code AND ca.course_code=tt.course_code AND ca.academic_year='$AcademicYear' AND c.semester='$Semester' AND c.course_code='$code'";
            $result = $conn->query($sql);

        } else {
            $sql = "SELECT * FROM time_table";
            $result = $conn->query($sql);
        }

        if (!$result) {
            die("Invalid Query: " . $conn->error);
        }
        ?>

        <div class="container my-5">
            <header class="d-flex justify-content-between my-3">
                <h1>Lecturer Time Schedule</h1>
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

                                    <div class="col-md-2">
                                        <select name="course_code" required class="form-select">
                                            <option value="">Select course</option>
                                            <?php
                                            $ccode = mysqli_query($conn, "SELECT DISTINCT course_code FROM course");
                                            while ($row = mysqli_fetch_array($ccode)) {
                                                $selected = isset($_GET['course_code']) && $_GET['course_code'] == $row['course_code'] ? 'selected' : '';
                                                ?>
                                                <option value="<?php echo $row['course_code'] ?>" <?= $selected ?>><?php echo $row['course_code'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="lecturer_time_schedule.php" class="btn btn-danger">Reset</a>    
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
                        <th>Chapter</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $row['chapter']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['start_time'] . ' - ' . $row['end_time']; ?></td>
                            <td>
                                <a href="lecturer_time_schedule_edit.php?id=<?php echo $row["id"]; ?>" class="btn btn-primary">edit</a>
                                <a href="lecturer_time_schedule_delete.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger">delete</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class = "container">
        <button class = "btn btn-primary my-5"><a href="lecturer_time_schedule_add.php" class="text-light"> Add New</a></button>
</div>
</body>
</html>
