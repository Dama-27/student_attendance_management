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
	<title>Lecturer Dashboard</title>

	<link rel="stylesheet" type="text/css" href="lecturer.css">

	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>

	<header class="header">
		
		<a href="lecturerhome.php">Lecturer Dashboard</a>

		<div class="logout">
			
			<a href="../login/logout.php" class="btn btn-primary">Logout</a>

		</div>

	</header>
	<?php
    include("lecturer_sidebar.php");
    $username = $_SESSION['username'];
    $sql = "SELECT fname, lname FROM lecturer WHERE email = '$username'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    ?>
	<div class="content">
		
		<h1>Lecturer Home</h1>
		<h2><?php echo "Welcome To The System " . $row['fname'] . " " . $row['lname']; ?></h2>


	</div>

</body>
</html>