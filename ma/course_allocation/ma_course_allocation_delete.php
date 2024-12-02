<?php
include '../../db_connection.php';

if(isset($_GET['course_code'])){
    $lecturer_id = $_GET['lecturer_id'];
    $academic_year = $_GET['academic_year'];
    $course_code = $_GET['course_code'];

    $sql = "DELETE FROM lecturer_course WHERE lecturer_id='$lecturer_id'";
    $sql1 = "DELETE FROM course_allocation WHERE course_code='$course_code' AND academic_year='$academic_year'";
    $result = mysqli_query($conn, $sql);

    if($result){
       if(mysqli_query($conn, $sql1)){
        header('location:ma_course_allocation.php');
       }
       
    } else {
        die(mysqli_error($conn));
    }
}
?>