<?php
session_start();
include("../../db_connection.php");

if ($conn === false) {
    die("connection error");
}
$username=$_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Report</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="report">
        <h1>Reports</h1>
        <div class="filters">
            <select id="course">
                <option value="">Course</option>
            </select>
            <input type="date" id="date">
            <select id="academic-year">
                <option value="">Academic Year</option>
            </select>
            <select id="semester">
                <option value="">semester 1</option>
                <option value="">semester 2</option>
                <option value="">semester 3</option>
                <option value="">semester 4</option>
                <option value="">semester 5</option>
                <option value="">semester 6</option>
                <option value="">semester 7</option>
                <option value="">semester 8</option>
            </select>
            <button id="load">Load</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Reg-No</th>
                    <th>Name</th>
                    <th>Present/Absent</th>
                    <th>Total</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody id="report-table-body">
            </tbody>
        </table>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
