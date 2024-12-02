<?php
include '../../db_connection.php';

if(isset($_GET['course_code'])){
    $course_code = $_GET['course_code'];

    $sql = "DELETE FROM course WHERE course_code='$course_code'";
    $result = mysqli_query($conn, $sql);

    if($result){
       //echo "Deleted successfully";
       header('location:ma_course_list.php');
    } else {
        die(mysqli_error($conn));
    }
}
?>

