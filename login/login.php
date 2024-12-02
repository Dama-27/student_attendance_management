<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login Form</title>

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
				Login Form

				<h4>
					<?php 

					error_reporting(0);
					session_start();
					session_destroy();
			
				echo $_SESSION['loginMessage'];
			

					?>

				</h4>
			</center>
			
			<form action="login_check.php" method="POST" class="login_form">
				
				<div class="select-container">
				<label class="label_deg1">Who Are You</label>
					<select class="select-box" name="account_type">
						<option value="s1">Select Account Type</option>
						<option value="student">Student</option>
						<option value="ma">Managing Assistant</option>
						<option value="lecturer">Lecturer</option>
					</select>
					<div class="icon-container">
						<i class="fa-solid fa-angle-down"></i>
					</div>
				</div>

				<div>
					<label class="label_deg">Username</label>
					<input type="text" name="username" required autocomplete="off">
				</div>

				<div>
					<label class="label_deg">Password</label>
					<input type="Password" name="password" required utocomplete="off">
				</div>

				<div>
					
					<input class="btn btn-primary" type="submit" name="submit" value="Login">
				</div>

				<div >
					<label class="back_login">Don't have an account?</label>
					<a href="../student/student_register.php">Click here to register as a Student</a>
				</div>

			</form>


		</div>

	</center>

</body>
</html>
