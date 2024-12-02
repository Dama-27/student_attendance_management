<?php 
    error_reporting(0);
    session_start();
    session_destroy();
            
    if($_SESSION['message']){
        $message=$_SESSION['message'];
        echo "<script type='text/javascript'>
        alert('$message');
        window.location.href = 'student_register.php'; // Redirect to student_register.php
        </script>";
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Registration</title>

    <link rel="stylesheet" type="text/css" href="../style.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body background="../login/login-page-wallpapers.jpg" class="body_deg">

    <center>
        <div class="form_deg">
            <center class="title_deg">
                Registration Form
                <h4><?php ?></h4>
            </center>
            <?php 
                include("../db_connection.php");
                if (isset($_POST['submit'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $con_password = $_POST['con_password'];
                
                    //verifying the unique email
                    $verify_query = mysqli_query($conn, "SELECT * FROM student WHERE email='$username'");
                
                    if (mysqli_num_rows($verify_query) != 0) {
                        // email already exists
                        $message="This email is used, Try another One Please!";
                        echo "<script type='text/javascript'>
                        alert('$message');
                        window.location.href = 'student_register.php'; // Redirect to student_register.php
                        </script>";
                    } else {
                      
                        if($password == $con_password){
                            mysqli_query($conn, "INSERT INTO student(email,password) VALUES('$username', '$password')") or die("Error Occurred");
                            $successMessage = "Registration successfully!, Request has sent to MA";
                            echo "<script type='text/javascript'>
                            alert('$successMessage');
                            window.location.href = '../login/login.php'; // Redirect to login.php
                            </script>";
                        } else {
                            $pas_miss_match = "Password not matching!";
                            echo "<script type='text/javascript'>
                            alert('$pas_miss_match');
                            window.location.href = 'student_register.php'; // Redirect to student_register.php
                            </script>";

                        }
                    }
                } else {
            ?>
            <form action="" method="POST" class="login_form">
                <div>
                    <label class="label_deg">Enter Email</label>
                    <input type="text" name="username" required autocomplete="off" >
                </div>
                <div>
                    <label class="label_deg">Enter Password</label>
                    <input type="Password" name="password" required autocomplete="off">
                </div>
                <div>
                    <label class="label_deg">Confirm Password</label>
                    <input type="Password" name="con_password" required autocomplete="off">
                </div>
                <div>
                    <input class="btn btn-primary" type="submit" name="submit" value="register">
                </div>
                <div>
                    <label class="back_login">Back to login</label>
                    <a href="../login/login.php">Back to login</a>
                </div>
            </form>
            <?php } ?>
        </div>
    </center>

</body>
</html>
