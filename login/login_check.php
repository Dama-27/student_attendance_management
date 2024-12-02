<?php
error_reporting(0);
session_start();
include("../db_connection.php");

if ($conn === false) {
    die("connection error");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['account_type'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    //On page 1
    $_SESSION['username'] = $username;
    $_SESSION['type'] = $type;


    try {
        $sql = "SELECT * FROM `$type` WHERE email='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            // Set session variables or redirect based on account type
            if ($type == 'student' && $row['status'] == 'active') {

                header("location: ../studentlog/Student.php");
            } elseif($type == 'student' && $row['status'] == 'pending') {
                // Display a message if status is not 'active'
                $message = "Please wait until MA accepts the request";
                $_SESSION['loginMessage'] = $message;
                header("location: login.php");
            } elseif($type == 'ma'){
                header("location: ../ma/mahome.php");
            } elseif($type == "lecturer"){
                header("location: ../lecturer/lecturerhome.php");
            } else{
                header("location: login.php");
            }

        } else {
            // Username or password incorrect
            $message = "Username or password incorrect";
            $_SESSION['loginMessage'] = $message;
            header("location: login.php");
        }
    } catch (Exception $e) {
        // Handle exceptions if any
        $message = "Please select account type";
        $_SESSION['loginMessage'] = $message;
        header("location: login.php");
    }
}
?>
