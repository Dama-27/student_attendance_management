<?php
include("../db_connection.php");
session_start();

if ($conn === false) {
    die("connection error");
}
?>

<?php
if(!isset($_SESSION['username'])){
    header('Location: ../login/login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MA Dashboard</title>

    <link rel="stylesheet" type="text/css" href="ma.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>

    <header class="header">
        <a href="">Managing Assistant Dashboard</a>
        <div class="logout">
            <a href="../login/logout.php" class="btn btn-primary">Logout</a>
        </div>
    </header>

    <?php
    include("ma_sidebar.php");
    $username = $_SESSION['username'];
    $sql = "SELECT fname, lname FROM ma WHERE email = '$username'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    ?>

    <div class="content">
        <h1>Managing Assistant Dashboard</h1>
        <h2><?php echo "Welcome To The System " . $row['fname'] . " " . $row['lname']; ?></h2>

        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Count</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT 
                    (SELECT COUNT(1) FROM student) AS student_count,
                    (SELECT COUNT(1) FROM lecturer) AS lecturer_count,
                    (SELECT COUNT(1) FROM ma) AS ma_count";

                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                ?>

                <tr>
                    <td><?php echo "Number of Students";?></td>
                    <td><?php echo $row['student_count'];?></td>
                    <td>
                        <a href="ma_view_students.php" class="btn btn-outline-dark">View Students</a>
                    </td>
                </tr>

                <tr>
                    <td><?php echo "Number of Lecturers";?></td>
                    <td><?php echo $row['lecturer_count'];?></td>
                    <td>
                        <a href="ma_view_lecturers.php" class="btn btn-outline-dark">View Lecturers</a>
                    </td>
                </tr>

                <tr>
                    <td><?php echo "Number of Managing Assistants";?></td>
                    <td><?php echo $row['ma_count'];?></td>
                    <td>
                        <a href="ma_view_mas.php" class="btn btn-outline-dark">View Managing Assistants</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>