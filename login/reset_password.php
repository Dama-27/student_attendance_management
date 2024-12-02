<?php
//error_reporting(0);
session_start();
include("../db_connection.php");

if ($conn === false) {
    die("Connection error");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_SESSION['type'];
    $username = $_SESSION['username'];

    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $con_password = $_POST['con_password'];


    try {
        $sql = "SELECT * FROM `$type` WHERE email='$username' AND password='$old_password'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        // Check if the query returned a row, indicating successful login
        if ($row) {
            if ($row['password'] == $old_password) {
                if ($new_password == $con_password) {
                    $sql = "UPDATE `$type` SET `password`='$new_password' WHERE `email`='$username'";
                    if (mysqli_query($conn, $sql)) {
                        $successMessage = "Password change successful!";
                        echo "<script type='text/javascript'>
                                alert('$successMessage');
                                history.back();
                              </script>";
                    } else {
                        $Message = "Password update failed!";
                        echo "<script type='text/javascript'>
                                alert('$Message');
                                history.back();
                              </script>";
                    }
                } else {
                    $Message = "Confirmation password does not match!";
                    echo "<script type='text/javascript'>
                            alert('$Message');
                            history.back();
                          </script>";
                }
            } else {
                $Message = "Your old password does not match!";
                echo "<script type='text/javascript'>
                        alert('$Message');
                        history.back();
                      </script>";
            }
        } else {
            $Message = "Your old password does not match!";
            echo "<script type='text/javascript'>
                    alert('$Message');
                    history.back();
                  </script>";
        }
    } catch (Exception $e) {
        $Message = "An error occurred: " . $e->getMessage();
        echo "<script type='text/javascript'>
                alert('$Message');
                history.back();
              </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body background="login-page-wallpapers.jpg" class="body_deg">
    <center>
        <div class="form_deg">
            <center class="title_deg">
                Reset Password
                <h4>
                    <?php 
                    error_reporting(0);
                    session_start();
                    if (isset($_SESSION['loginMessage'])) {
                        echo $_SESSION['loginMessage'];
                    }
                    ?>
                </h4>
            </center>
            <form action="reset_password.php" method="POST" class="login_form">
                <div>
                    <label class="label_deg">Old Password</label>
                    <input type="password" name="old_password" required autocomplete="off">
                </div>
                <div>
                    <label class="label_deg">New Password</label>
                    <input type="password" name="new_password" required autocomplete="off">
                </div>
                <div>
                    <label class="label_deg">Confirm Password</label>
                    <input type="password" name="con_password" required autocomplete="off">
                </div>
                <div>
                    <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                    <button class="btn btn-danger" type="button" onclick="history.back()">Go Back</button>

                </div>

            </form>
        </div>
    </center>
</body>
</html>
