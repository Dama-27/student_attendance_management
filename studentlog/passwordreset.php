<?php
session_start();
include("../db_connection.php");

if ($conn === false) {
    die("connection error");
}
$username=$_SESSION['username'];
$type=$_SESSION['type'];
if(isset($_POST['submit'])){
    $currentpassword=$_POST['currentpassword'];
    $newpassword=$_POST['newpassword'];
         $sql = "SELECT * FROM `$type` WHERE email='$username' AND password='$currentpassword'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        
        if ($row) {
            
           $quary="UPDATE `student` SET `password`='$newpassword' WHERE email='$username';";
           if ($conn->query($quary) === TRUE) {
            echo "<script>alert('password update successfully')</script>";
            header("location:Student.php");
        }
         else {
            echo "<script>alert('Current password incorret')</script>";
        }
        }
        else {
            echo "<script>alert('Password can't update.Please retry!!')</script>";
        }
}






?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Password Reset</title>
    <style>
        body {
            background-image: url('background2.jpg'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            justify-content: center; 
            align-items: center;
            height: 100vh; 
            margin: 0; 
            padding: 0; 
        }
        .container {
            width: 400px;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.5); 
            border: 1px solid rgba(225, 225, 225, 0.15);
            backdrop-filter: blur(15px);
            --webkit-backdrop-filter: blur(15px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Password Reset</h1> 
        <form action="passwordreset.php" method="POST">
            <div class="mb-3">
                <label for="currentPassword" class="form-label">Current Password</label>
                <input type="password" class="form-control" id="currentPassword" name='currentpassword'>
            </div>
            <div class="mb-3">
                <label for="newPassword" class="form-label">New Password</label>
                <input type="password" class="form-control" id="newPassword" name='newpassword'>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>
</body>
</html>
