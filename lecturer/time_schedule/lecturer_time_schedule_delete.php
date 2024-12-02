<?php
include '../../db_connection.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM time_table WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if($result){
       // echo "Deleted successfully";
       header('location:lecturer_time_schedule.php');
    } else {
        die(mysqli_error($conn));
    }
}
?>

