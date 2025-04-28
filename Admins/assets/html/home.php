<?php
include_once("db.php");
if (!isset($_SESSION['teacher'])) {
  // No teacher_code in session, redirect to login page
  header('Location: ../../index.php');
  
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Attendance Portal</title>
   <link rel="stylesheet" href="../css/style.css">
</head>
<body>
   
    <div class="navbar hidden" id="navbarContainer">
        <div class="com_nav">
    <div class="l_nav"><h3>Admin Portal</h3></div>
    <div class="r_nav">
        <button>Mark Attendence</button>
        <button>View Records</button>
        <button onclick="window.location.href='scanner.php'">Scanner</button>
        <button onclick="window.location.href='registration_form.php'">Registration</button>
        <button class="logout-btn" onclick="logout()" >Logout</button>
    </div>
  </div>
  <div class="menu-icon" onclick="toggleMenu()">
    <div></div>
    <div></div>
    <div></div>
  </div>
</div>


<div class="side-menu" id="sideMenu">
  <div id="cut" onclick="closeMenu()">×</div>
  <button onclick="scrollToSection('attendanceSection')">Mark Attendance</button>
  <button onclick="scrollToSection('recordsSection')">View Records</button>
  <button onclick="window.location.href='scanner.php'">Scanner</button>
  <button onclick="window.location.href='registration_form.php'">Registration</button>
  <button onclick="logout()" class="logout-btn" >Logout</button>
</div>

<script src="../js/script.js"></script>
</body>
</html>
