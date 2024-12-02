<?php
include("../../db_connection.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance Management</title>
    <link rel="stylesheet" href="attendancestyle.css">
    
</head>
<body>
    <div class="container">
        <h1>Take Attendance</h1>
        <form id="attendanceForm" method="post" action="save_attendance.php">
            <div class="form-row">
                <label for="academicYear">Academic Year:</label>
                <select name="academic_year" id="academic_year"  class="form-select"> <!--required-->
                    <option value="">Select Academic Year</option>
                    <?php
                    $acyear = mysqli_query($conn, "SELECT DISTINCT academic_year FROM course_allocation");
                    if (!$acyear) {
                        die("Query failed: " . mysqli_error($conn));
                    }
                    while ($row = mysqli_fetch_array($acyear)) {
                        $selected = isset($_GET['academic_year']) && $_GET['academic_year'] == $row['academic_year'] ? 'selected' : '';
                        echo "<option value='{$row['academic_year']}' {$selected}>{$row['academic_year']}</option>";
                    }
                    ?>
                </select>
                
                <label for="semester">Semester:</label>
                <select name="semester" id="semester" required class="form-select">
                    <option value="">Select Semester</option>
                    <?php
                    $sem = mysqli_query($conn, "SELECT DISTINCT semester FROM course");
                    if (!$sem) {
                        die("Query failed: " . mysqli_error($conn));
                    }
                    while ($row = mysqli_fetch_array($sem)) {
                        $selected = isset($_GET['semester']) && $_GET['semester'] == $row['semester'] ? 'selected' : '';
                        echo "<option value='{$row['semester']}' {$selected}>{$row['semester']}</option>";
                    }
                    ?>
                </select>
                
                <label for="course">Course:</label>
                <select name="course_code" id="course_code" required class="form-select">
                    <option value="">Select Course Code</option>
                </select>
            </div>

            <div class="form-row">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>

                <label for="time">Time Period:</label>
                <select name="time" id="time" required class="form-select">
                    <option value="8.00 am - 9.00 am">8.00 am - 9.00 am</option>
                    <option value="9.00 am - 10.00 am">9.00 am - 10.00 am</option>
                    <option value="10.00 am - 11.00 am">10.00 am - 11.00 am</option>
                    <option value="11.00 am - 12.00 pm">11.00 am - 12.00 pm</option>
                    <option value="12.00 pm - 1.00 pm">12.00 pm - 1.00 pm</option>
                    <option value="1.00 pm - 2.00 pm">1.00 pm - 2.00 pm</option>
                    <option value="2.00 pm - 3.00 pm">2.00 pm - 3.00 pm</option>
                    <option value="3.00 pm - 4.00 pm">3.00 pm - 4.00 pm</option>
                </select>
                
                <!-- <label for="start_time">Start Time:</label>
                <select name="start_time" id="start_time" required class="form-select">
                    <option value="8.00 am">8:00 am</option>
                    <option value="9.00 am">9:00 am</option>
                    <option value="10.00 am">10:00 am</option>
                    <option value="11.00 am">11:00 am</option>
                    <option value="12.00 pm">12:00 pm</option>
                    <option value="1.00 pm">1:00 pm</option>
                    <option value="2.00 pm">2:00 pm</option>
                    <option value="3.00 pm">3:00 pm</option>
                </select>

                <label for="end_time">End Time:</label>
                <select name="end_time" id="end_time" required class="form-select">
                    <option value="9.00 am">9:00 am</option>
                    <option value="10.00 am">10:00 am</option>
                    <option value="11.00 am">11:00 am</option>
                    <option value="12.00 pm">12:00 pm</option>
                    <option value="1.00 pm">1:00 pm</option>
                    <option value="2.00 pm">2:00 pm</option>
                    <option value="3.00 pm">3:00 pm</option>
                    <option value="4.00 pm">4:00 pm</option>
                </select> -->

                <label for="lecturer">Lecturer:</label>
                <select name="lecturer" id="lecturer"  class="form-select"> <!--required-->
                    <option value="">Select Lecturer</option>
                </select>
            </div>

            <div class="attendance-table">
                <table>
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Registration No</th>
                            <th>Status</th>
                            <th>Present</th>
                        </tr>
                    </thead>
                    <tbody id="students">
                        <!-- Attendance records will be populated here via AJAX -->
                    </tbody>
                </table>
            </div>
            <div class="form-row">
                <label for="allPresent">All Present:</label>
                <input type="checkbox" id="allPresent">
            </div>
            <div class="form-row">
                <button type="submit" name="submit">Save</button>
                <button type="button" onclick="history.back()" style="background-color: red; color: white;">Go Back</button>
            </div>
        </form>
    </div>
    <script src="attendance.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>    
    <script>
        $(document).ready(function() {
            function loadAttendance() {
                var courseCode = $("#course_code").val();
                var date = $("#date").val();
                // var startTime = $("#start_time").val();
                // var endTime = $("#end_time").val();
                var time = $("#time").val();
                if (courseCode && date && time) {
                    var attendanceURL = "get_attendance.php?course_code=" + courseCode + "&date=" + date + "&time=" + time ;
                    $.get(attendanceURL, function(data, status) {
                        $("#students").html(data);
                    });
                }
            }

            $("#semester, #academic_year").on("change", function() {
                var semester = $("#semester").val();
                var academicYear = $("#academic_year").val();
                
                // Only proceed if both semester and academic year are selected
                if (semester && academicYear) {
                    var getURL = "get_course_code.php?semester=" + semester + "&academic_year=" + academicYear;
                    $.get(getURL, function(data, status) {
                        $("#course_code").html(data);
                    });
                }
            });

            $("#course_code").on("change", function() {
                var courseCode = $("#course_code").val();
                if (courseCode) {
                    var lecturerURL = "get_lecturer.php?course_code=" + courseCode;
                    $.get(lecturerURL, function(data, status) {
                        $("#lecturer").html(data);
                    });

                    loadAttendance();
                }
            });

            $("#date").on("change", loadAttendance);
            $("#time").on("change", loadAttendance);
            // $("#end_time").on("change", loadAttendance);

            $("#allPresent").on("change", function() {
                var isChecked = $(this).is(":checked");
                $("#students input[type=checkbox]").each(function() {
                    $(this).prop("checked", isChecked);
                });
            });

            $("#attendanceForm").on("submit", function(e) {
                e.preventDefault(); // Prevent the default form submission

                var formData = $(this).serialize();

                $.post("save_attendance.php", formData, function(response) {
                    alert(response);
                    // Optionally, you can reload the attendance list here
                    loadAttendance();
                });
            });
        });
    </script>
</body>
</html>