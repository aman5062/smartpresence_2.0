<?php
include_once("db.php");
if (!isset($_SESSION['teacher'])=="active") {
  // No teacher_code in session, redirect to login page
  header('Location: ../../index.php');
    exit();
}

?>

<?php
session_start();
include 'db.php'; // your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['unique_code']) || empty($_POST['unique_code'])) {
        echo "❌ No code received.";
        exit;
    }

    $unique_code = mysqli_real_escape_string($conn, $_POST['unique_code']);
    $teacher_code = $_SESSION['teacher_code']; // teacher_code from session

    // Step 1: Find user
    $query = "SELECT * FROM user WHERE unique_code = '$unique_code' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        echo "❌ User not found.";
        exit;
    }

    $row = mysqli_fetch_assoc($result);
    $name = $row['Name'];
    $class = $row['Class'];
    $sec = $row['sec'];
    $enrollment_no = $row['Enrollment_no'];

    $date_time = date('Y-m-d H:i:s'); // full datetime
    $time_span = date('H:i:s'); // current time

    // Step 2: Check if already marked
    $check = "SELECT * FROM attendence 
              WHERE Enrollment_no = '$enrollment_no' 
              AND DATE(Date_Time) = CURDATE() 
              AND Teacher_code = '$teacher_code'";

    $checkResult = mysqli_query($conn, $check);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "⚠️ Attendance Already Marked Today.";
        exit;
    }

    // Step 3: Insert attendance
    $insert = "INSERT INTO attendence (`TimeSpan`, `Name`, `Class`, `Sec`, `Enrollment_no`, `Date_Time`, `Teacher_code`) 
               VALUES ('$time_span', '$name', '$class', '$sec', '$enrollment_no', '$date_time', '$teacher_code')";

    if (mysqli_query($conn, $insert)) {
        echo "✅ Attendance Marked Successfully.";
    } else {
        echo "❌ Error while marking attendance.";
    }
}
?>
