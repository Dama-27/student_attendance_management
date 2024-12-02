<?php

include '../../db_connection.php';

if(isset($_GET['lecturer_id'])){
    $lecturer_id = $_GET['lecturer_id'];

    $sql = "DELETE FROM lecturer WHERE lecturer_id='$lecturer_id'";
    $result = mysqli_query($conn, $sql);

    if($result){
       //echo "Deleted successfully";
       header('location:ma_lecturer_list.php');
    } else {
        die(mysqli_error($conn));
    }
}
?>

