<?php
include_once("db.php");
if (!isset($_SESSION['teacher'])=="active") {
  // No teacher_code in session, redirect to login page
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
  <style>
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f4f7fb;
  color: #333;
}

/* Navbar Styles */
.navbar {
  width: 100%;
  background-color: #3b82f6;
  color: white;
  padding: 10px 20px;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 100;
}

.com_nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.l_nav h3 {
  font-size: 1.8rem;
  font-weight: bold;
  letter-spacing: 1px;
}

.r_nav button {
  background-color: #3b82f6;
  color: white;
  padding: 8px 15px;
  margin: 5px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.r_nav button:hover {
  background-color: #2563eb;
  transform: scale(1.05);
}

.logout-btn {
  background-color: #ef4444;
}

.logout-btn:hover {
  background-color: #dc2626;
}

/* Side Menu Styles */
.side-menu {
  width: 250px;
  background-color: #ffffff;
  position: fixed;
  top: 0;
  left: -250px;
  height: 100%;
  padding-top: 60px;
  box-shadow: 2px 0px 15px rgba(0, 0, 0, 0.1);
  transition: 0.3s;
}

.side-menu button {
  width: 100%;
  padding: 15px;
  border: none;
  text-align: left;
  background-color: #f4f7fb;
  font-size: 1.1rem;
  border-bottom: 1px solid #ddd;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.side-menu button:hover {
  background-color: #3b82f6;
  color: white;
}

#cut {
  position: absolute;
  top: 20px;
  right: 20px;
  font-size: 1.8rem;
  cursor: pointer;
  color: #333;
  background-color: transparent;
  border: none;
}

/* Form Container Styles */
.form-container {
  margin-top: 90px;
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
  color: #333;
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
  border-color: #3b82f6;
  box-shadow: 0 0 8px rgba(59, 130, 246, 0.4);
}

form button {
  background-color: #3b82f6;
  color: white;
  cursor: pointer;
  border: none;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

form button:hover {
  background-color: #2563eb;
  transform: scale(1.05);
}

@keyframes slideInMenu {
  from {
    left: -250px;
  }
  to {
    left: 0;
  }
}

@keyframes slideOutMenu {
  from {
    left: 0;
  }
  to {
    left: -250px;
  }
}

/* Mobile Responsive */
@media (max-width: 768px) {
  .navbar {
    padding: 15px;
  }

  .r_nav button {
    padding: 8px 12px;
    font-size: 0.9rem;
  }

  .side-menu {
    width: 100%;
  }

  .side-menu button {
    font-size: 1rem;
  }

  .form-container {
    margin-top: 120px;
    padding: 20px;
  }

  .form-container h2 {
    font-size: 1.6rem;
  }

  form input, form select, form button {
    font-size: 1rem;
  }
}

  </style>
</head>
<body>
<div class="navbar">
    <div class="com_nav">
      <div class="l_nav"><h3>Admin Portal</h3></div>
      <div class="r_nav">
        <button onclick="homepg()">Homepage</button>
        <button>Mark Attendance</button>
        <button>View Records</button>
        <button>Scanner</button>
        <button class="logout-btn" onclick="logout()">Logout</button>
      </div>
    </div>
  </div>

  <div class="side-menu" id="sideMenu">
    <div id="cut" onclick="closeMenu()">×</div>
    <button onclick="homepg()">Homepage</button>
    <button onclick="scrollToSection('attendanceSection')">Mark Attendance</button>
    <button onclick="scrollToSection('recordsSection')">View Records</button>
    <button onclick="scrollToSection('Scanner')">Scanner</button>
    <button onclick="logout()">Logout</button>
  </div>

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
      window.location.href = "home.html";
    }

    function logout() {
      alert("Logging out...");
    }

    function closeMenu() {
      document.getElementById('sideMenu').classList.remove('show');
    }

    function scrollToSection(sectionId) {
      const section = document.getElementById(sectionId);
      section.scrollIntoView({ behavior: 'smooth' });
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