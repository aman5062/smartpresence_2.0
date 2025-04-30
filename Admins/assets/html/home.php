<?php
include_once("db.php");
if (!isset($_SESSION['teacher'])) {
  header('Location: ../../index.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Attendance Portal</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f3f4f6;
      padding-top: 70px;
    }

    /* Navbar */
    .navbar {
      position: fixed;
      top: 0;
      width: 100%;
      background-color: #1e40af;
      color: white;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 15px 20px;
      z-index: 1000;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .l_nav h3 {
      margin: 0;
      font-size: 22px;
    }

    .r_nav {
      display: flex;
      gap: 12px;
    }

    .r_nav button {
      background-color: transparent;
      border: 1px solid white;
      color: white;
      padding: 8px 14px;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.3s;
    }

    .r_nav button:hover {
      background-color: white;
      color: #1e40af;
    }

    .logout-btn {
      background-color: #ef4444;
      border: none;
      color: white;
    }

    .logout-btn:hover {
      background-color: #dc2626;
    }

    .menu-icon {
      display: none;
      flex-direction: column;
      cursor: pointer;
      gap: 4px;
    }

    .menu-icon div {
      width: 25px;
      height: 3px;
      background-color: white;
    }

    @media (max-width: 768px) {
      .r_nav {
        display: none;
      }
      .menu-icon {
        display: flex;
      }
    }

    /* Side Menu */
    .side-menu {
      position: fixed;
      top: 0;
      left: -250px;
      width: 250px;
      height: 100%;
      background-color: #1e40af;
      color: white;
      display: flex;
      flex-direction: column;
      padding: 20px;
      transition: left 0.3s ease-in-out;
      z-index: 1001;
    }

    .side-menu button {
      background: transparent;
      border: none;
      color: white;
      padding: 12px;
      text-align: left;
      font-size: 16px;
      border-bottom: 1px solid rgba(255,255,255,0.2);
      cursor: pointer;
    }

    .side-menu button:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }

    #cut {
      font-size: 24px;
      align-self: flex-end;
      cursor: pointer;
      margin-bottom: 20px;
    }

    /* Sample Content */
    .main-content {
      padding: 30px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <div class="l_nav">
      <h3>Admin Portal</h3>
    </div>
    <div class="r_nav">
      <button onclick="scrollToSection('attendanceSection')">Mark Attendance</button>
      <button onclick="scrollToSection('recordsSection')">View Records</button>
      <button onclick="window.location.href='scanner.php'">Scanner</button>
      <button onclick="window.location.href='registration_form.php'">Registration</button>
      <button class="logout-btn" onclick="logout()">Logout</button>
    </div>
    <div class="menu-icon" onclick="toggleMenu()">
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>

  <!-- Side Menu -->
  <div class="side-menu" id="sideMenu">
    <div id="cut" onclick="closeMenu()">×</div>
    <button onclick="scrollToSection('attendanceSection')">Mark Attendance</button>
    <button onclick="scrollToSection('recordsSection')">View Records</button>
    <button onclick="window.location.href='scanner.php'">Scanner</button>
    <button onclick="window.location.href='registration_form.php'">Registration</button>
    <button class="logout-btn" onclick="logout()">Logout</button>
  </div>

  <!-- Sample Page Content -->
  <div class="main-content">
    <h2>Welcome to the Admin Portal</h2>
    <p>This is a placeholder content section. Add your dashboard or tools here.</p>
  </div>

  <!-- JS -->
  <script>
    function toggleMenu() {
      document.getElementById('sideMenu').style.left = "0";
    }

    function closeMenu() {
      document.getElementById('sideMenu').style.left = "-250px";
    }

    function logout() {
      window.location.href = "../../logout.php";
    }

    function scrollToSection(id) {
      alert("This would scroll to: " + id);
    }
  </script>

</body>
</html>
