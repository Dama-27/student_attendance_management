<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Course List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #03045e;
            margin: 0;
            padding: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            margin-top: 0;
            text-align: center;
            margin-bottom: 20px;
        }
        .message {
            text-align: center;
            font-style: italic;
            margin-top: 20px;
        }
        .button {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 10px 20px;
            text-align: center;
            background-color: #DC143C;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .button:hover {
            background-color: #FF6347;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Course List</h2>
        
        <?php
        require_once "../php/db_connection.php"; 

        $sql = "SELECT `Code`, `Name`, `Credit`, `Id`, `Semester` FROM `course`";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $table = '<table>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Credit</th>
                            <th>Id</th>
                            <th>Semester</th>
                        </tr>';
        
            while ($row = $result->fetch_assoc()) {
                $table .= '<tr>
                            <td>' . $row['Code'] . '</td>
                            <td>' . $row['Name'] . '</td>
                            <td>' . $row['Credit'] . '</td>
                            <td>' . $row['Id'] . '</td>
                            <td>' . $row['Semester'] . '</td>
                        </tr>';
            }
        
            $table .= '</table>';
        
            echo $table;
        } else {
            echo '<p class="message">No courses found.</p>';
        }

        $conn->close();
        ?>

        <a href="CreateCourse.php" class="button">Add New Course</a>
    </div>
</body>
</html>
