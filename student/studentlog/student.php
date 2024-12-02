<?php
session_start();
include("../db_connection.php");

if ($conn === false) {
    die("connection error");
}
$username=$_SESSION['username'];
$quary="SELECT batch,fname,reg_no,academic_year from student where email='$username';";
$result = mysqli_query($conn, $quary);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $batch=$row['batch'];
    $fname=$row['fname'];
    $reg_no=$row['reg_no'];
    $academic_year=$row['academic_year'];
}else{
    echo "<script>alert('Sorry!! You are not in the system.please discuss with the management assitant')</script>";
    header("location: ../login/login.php");
}






?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Student Dashboard</title>
    <style>
        body {
            background-image: url('background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            position: relative;
        }
        .dropdown-container {
            position: absolute;
            top: 20px;
            left: 20px;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 10px;
            padding: 20px;
            width: 80%;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card {
            margin-bottom: 15px;
        }
        .card-body {
            padding: 10px;
        }
        .card-title {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="dropdown-container">
        <div class="dropdown">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Menu
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="">Dashboard</a></li>
                <li><a class="dropdown-item" href="passwordreset.php">Password Reset</a></li>
                <li><a class="dropdown-item" href="studentattendace.php">Attendance</a></li>
                <li><a class="dropdown-item" href="../index.php">Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <h5 style="text-align:center;">Welcome! <?php  echo $fname ?></h5>
        <div class="card mx-auto" style="width: 100% ;">
            <div class="card-body">
                <h5 class="card-title">Batch No: <?php  echo $batch ?></h5>  
            </div>
            <div class="card-body">
                <h5 class="card-title">Reg No: <?php  echo $reg_no ?></h5>  
            </div>
            <div class="card-body">
                <h5 class="card-title">Academic Year: <?php  echo $academic_year ?></h5>  
            </div>
            <div class="card-body">
                <h5 class="card-title">Email: <?php echo $username?></h5>  
            </div>
            
        </div>
    </div>
</body>
</html>
