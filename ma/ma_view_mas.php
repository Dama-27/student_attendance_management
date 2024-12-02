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
    <title>MA view MAS</title>
    <link rel="stylesheet" type="text/css" href="ma.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
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
    ?>

    <div class="content">
        <?php
            $sql = "SELECT email, lname, fname
                    FROM ma ORDER BY fname ASC";
            
            $result = $conn->query($sql);

        if (!$result) {
            die("Invalid Query: " . $conn->error);
        }
        ?>
<div class="container my-5">
    <header class="d-flex justify-content-between my-3">
        <h1>View Students</h1>
    </header>
    </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>email</th>
                        <th>Name</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['fname'] . ' ' . $row['lname']; ?></td>

                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <table class="table table-bordered">

            <a href="mahome.php" class="btn btn-danger">Back</a>

</body>
</html>
