<?php
include_once("db.php");
if (!isset($_SESSION['teacher'])=="active") {
  header('Location: ../../index.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Registration</title>
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

    /* Form Container */
    .form-container {
      padding: 30px;
      background-color: #b3d0ff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      max-width: 700px;
      margin: 80px auto;
    }

    .form-container h2 {
      text-align: center;
      font-size: 2rem;
      margin-bottom: 20px;
      color: #1e40af;
    }

    form label {
      font-size: 1rem;
      margin-bottom: 5px;
      color: #000000;
      display: block;
    }

    form input, form select, form button {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
      color: #333;
    }

    form input:focus, form select:focus {
      outline: none;
      border-color: #1e40af;
      box-shadow: 0 0 8px rgba(30, 64, 175, 0.3);
    }

    form button {
      background-color: #1e40af;
      color: white;
      cursor: pointer;
      border: none;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    form button:hover {
      background-color: #2563eb;
      transform: scale(1.05);
    }

    @media (max-width: 768px) {
      .form-container {
        margin-top: 120px;
        padding: 20px;
      }

      .form-container h2 {
        font-size: 1.6rem;
      }
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
    <button onclick="homepg()">Homepage</button>
    <button onclick="scrollToSection('attendanceSection')">Mark Attendance</button>
    <button onclick="scrollToSection('recordsSection')">View Records</button>
    <button onclick="scanner()">Scanner</button>
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
  <button onclick="homepg()">Homepage</button>
  <button onclick="scrollToSection('attendanceSection')">Mark Attendance</button>
  <button onclick="scrollToSection('recordsSection')">View Records</button>
  <button onclick="scanner()">Scanner</button>
  <button class="logout-btn" onclick="logout()">Logout</button>
</div>

<!-- Form -->
<div class="form-container">
  <h2>Student Registration</h2>
  <form id="studentForm" enctype="multipart/form-data">
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" required placeholder="Enter Your Name"/>

    <label for="class">Program</label>
    <select id="class" name="class" required>
      <option value="">Select Program</option>
      <option value="B. TECH">B. TECH</option>
      <option value="BCA">BCA</option>
      <option value="BCOM">BCOM</option>
    </select>

    <label for="section">Section</label>
    <select id="section" name="section" required>
      <option value="">Select Section</option>
      <option value="A">A</option>
      <option value="B">B</option>
      <option value="C">C</option>
      <option value="D">D</option>
    </select>

    <label for="enrollment">Enrollment Number</label>
    <input type="text" id="enrollment" name="enrollment" required placeholder="Enter Your Enrollment Number"/>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required placeholder="Enter Your Email"/>

    <label for="phone">Phone Number</label>
    <input type="tel" id="phone" name="phone" required pattern="[0-9]{10}" placeholder="10-digit phone number" />

    <label for="photo">Upload Photo</label>
    <input type="file" id="photo" name="photo" accept="image/*" required />

    <button type="submit">Submit</button>
  </form>
</div>

<script>
  function homepg() {
    window.location.href = "home.php";
  }

  function scanner() {
    window.location.href = "scanner.php";
  }

  function logout() {
    window.location.href = "../../logout.php";
  }

  function toggleMenu() {
    document.getElementById("sideMenu").style.left = "0";
  }

  function closeMenu() {
    document.getElementById("sideMenu").style.left = "-250px";
  }

  function scrollToSection(sectionId) {
    alert("This would scroll to: " + sectionId);
  }

  document.getElementById("studentForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const form = document.getElementById("studentForm");
    const formData = new FormData(form);

    fetch("register.php", {
      method: "POST",
      body: formData
    })
    .then(response => response.text())
    .then(data => {
      alert(data);
      form.reset();
    })
    .catch(error => {
      console.error("Error:", error);
      alert("Submission failed. Try again.");
    });
  });
</script>

</body>
</html>