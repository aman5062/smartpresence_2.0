<?php

include_once("db.php");

$Phone = $_POST["phone"];
$Password = $_POST["password"];

// Sanitize input (basic)
$Phone = mysqli_real_escape_string($conn, $Phone);
$Password = mysqli_real_escape_string($conn, $Password);

// Hash the input password using MD5
$hashedPassword = md5($Password);

// SQL to check if credentials match
$sql = "SELECT * FROM teacher WHERE Phone = '$Phone' AND Password = '$hashedPassword'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    // Login successful
    $user = mysqli_fetch_assoc($result);
    $_SESSION['teacher_name'] = $user['Name'];
    $_SESSION['teacher_code'] = $user['Teacher_code'];
    $_SESSION['teacher'] = "active";
    
    header("Location: home.php");
    // header("Location: dashboard.php"); // Uncomment to redirect
    exit;
} else {
    // Login failed
    header('Location: ../../index.php?error=Wrong username or password');
}
?>
