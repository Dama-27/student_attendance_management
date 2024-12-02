<?php
include("../../db_connection.php");
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student List</title>

    <link rel="stylesheet" type="text/css" href="../ma.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
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
        <li><a href="ma_student_list.php">Student List</a></li>
        <li><a href="../lecturer_list/ma_lecturer_list.php">Lecturer List</a></li>
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
if (isset($_GET['batch']) && $_GET['batch'] != '') {
    $batch = $_GET['batch'];
    $sql = "SELECT `reg_no`, `fname`, `lname`, `email`, `status`
            FROM student
            WHERE batch = '$batch'";
    $result = $conn->query($sql);
} else {
    $sql = "SELECT `reg_no`, `fname`, `lname`, `email`, `status`
            FROM student";
    $result = $conn->query($sql);
}

if (!$result) {
    die("Invalid Query: " . $conn->error);
}
?>
<div class="container my-5">
    <header class="d-flex justify-content-between my-3">
        <h1>Student List</h1>
    </header>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                    <form action="" method="GET">
                        <div class="row">
                            <div class="col-md-2">
                                <select name="batch" required class="form-select">
                                    <option value="">Select batch</option>
                                    <?php
                                    $batch = mysqli_query($conn, "SELECT DISTINCT batch FROM student");
                                    while ($row = mysqli_fetch_array($batch)) {
                                        $selected = isset($_GET['batch']) && $_GET['batch'] == $row['batch'] ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $row['batch'] ?>" <?= $selected ?>><?php echo $row['batch'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="ma_student_list.php" class="btn btn-danger">Reset</a>
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
            <th>Name</th>
            <th>Email</th>
            <th>Registration NO</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = $result->fetch_assoc()) {
        ?>
            <tr>    
                <td><?php echo $row['fname'] . ' ' . $row['lname'];?></td>                      
                <td><?php echo $row['email'];?></td>
                <td><?php echo $row['reg_no'];?></td>                      
                <td><?php echo $row['status'];?></td>
                <td>
                    <a href="ma_student_list_edit.php?email=<?php echo $row["email"]; ?>" class="btn btn-info">Edit</a>
                    <a href="ma_student_list_delete.php?email=<?php echo $row["email"]; ?>" class="btn btn-danger">Delete</a>
                    <?php
                    if ($row['status'] == "pending") {
                        echo '<a href="ma_student_list_accept.php?email=' . $row["email"] . '" class="btn btn-primary">Accept</a> ';
                    }
                    ?>
                </td>                    
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
    <div class="col-md-4">
        <a href="ma_student_list_create.php" class="btn btn-primary">Add Student</a>
    </div>
</div>

</body>
</html>