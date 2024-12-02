<?php
include '../../db_connection.php';

if(isset($_GET['email'])){
    $email = $_GET['email'];

    $sql = "DELETE FROM student WHERE email='$email'";
    
    $result = mysqli_query($conn, $sql);

    if($result){
       //echo "Deleted successfully";
       header('Location: ma_student_list.php');
    } else {
        die(mysqli_error($conn));
    }
}
?>

