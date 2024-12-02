<?php
error_reporting(0);
session_start();
include("../db_connection.php");

if ($conn === false) {
    die("connection error");
}

$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $semester = $_POST['semester'];

    $query_co = "SELECT DISTINCT attendance.course_code 
                 FROM attendance 
                 JOIN course ON attendance.course_code = course.course_code 
                 WHERE course.semester = '$semester'";

    $result_co = mysqli_query($conn, $query_co);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Student Attendance</title>
    <style>
        body {
            background-image: url('background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
        .dropdown-container {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .dropdown select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
            width: 200px;
            font-size: 16px;
            outline: none;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        .dropdown select:hover {
            background-color: #f8f8f8;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .dropdown button {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            margin-left: 10px;
        }
        .dropdown button:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
            width: 80%;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 100px; 
        }
        .table {
            background-color: rgba(255, 255, 255, 0.5);
            margin-top: 20px;
        }
        h1 {
            color: #333;
            font-size: 2em;
            margin-bottom: 20px;
        }
        th, td {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="dropdown-container">
        <form action="" method="post">
            <div class="dropdown">
                <select name="semester" id="semester" required>
                    <option value="" disabled selected>Select Semester</option>
                    <option value="semester 1">semester 1</option> 
                    <option value="semester 2">semester 2</option> 
                    <option value="semester 3">semester 3</option> 
                    <option value="semester 4">semester 4</option>
                    <option value="semester 5">semester 5</option> 
                    <option value="semester 6">semester 6</option> 
                    <option value="semester 7">semester 7</option> 
                    <option value="semester 8">semester 8</option>
                </select>
                <button name='submit' type='submit'>SELECT</button>
            </div>
        </form>
    </div>

    <div class="container">
        <h1>Student Attendance</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Subject</th>
                    <th scope="col">Percentage</th>
                    <th scope="col">Pass/Fail</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($result_co) && $result_co->num_rows > 0) {
                    while ($row_co = mysqli_fetch_assoc($result_co)) {
                        $course_code = $row_co['course_code'];

                        $query = "SELECT COUNT(attendance.status) AS present_count 
                                  FROM attendance 
                                  JOIN student ON attendance.reg_no = student.reg_no 
                                  WHERE attendance.status = 'present' 
                                  AND attendance.course_code = '$course_code' 
                                  AND student.email = '$username'";

                        $query_tot = "SELECT COUNT(attendance.status) AS total_count 
                                      FROM attendance 
                                      JOIN student ON attendance.reg_no = student.reg_no 
                                      WHERE student.email = '$username' 
                                      AND attendance.course_code = '$course_code'";

                        $result_tot = mysqli_query($conn, $query_tot);
                        $result = mysqli_query($conn, $query);

                        $row_tot = mysqli_fetch_assoc($result_tot);
                        $row = mysqli_fetch_assoc($result);

                        $total_days = $row_tot['total_count'];
                        $present_days = $row['present_count'];
                        $percentage = ($total_days > 0) ? ($present_days / $total_days) * 100 : 0;
                        $status = ($percentage >= 75) ? "Pass" : "Fail";

                        echo "<tr>
                                <th scope='row'>$course_code</th>
                                <td>" . round($percentage, 2) . "%</td>
                                <td>$status</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No courses found for the selected semester.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
