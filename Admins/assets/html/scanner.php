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
  <title>QR Code Scanner</title>
  <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
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

    .scanner-container {
      margin-top: 40px;
      padding: 30px;
      text-align: center;
      background: linear-gradient(135deg, #6ee7b7, #3b82f6);
      border-radius: 15px;
      width: 90%;
      margin-inline: auto;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    #reader {
  width: 100%;
  max-width: 500px;
  aspect-ratio: 1;
  margin: 0 auto;
  overflow: hidden;
  position: relative;
  border-radius: 15px;
  background-color: #ffffff;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

#reader video {
  width: 100% !important;
  height: 100% !important;
  object-fit: cover;
  border-radius: 15px;
}
    #result {
      margin-top: 20px;
      font-size: 1.2rem;
      font-weight: bold;
      color: #000;
    }

    .scan-btn {
      margin-top: 20px;
      padding: 12px 25px;
      font-size: 1rem;
      background-color: #2563eb;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .scan-btn:hover {
      background-color: #1d4ed8;
      transform: scale(1.1);
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
    <button onclick="window.location.href='home.php'">Homepage</button>
    <button onclick="scrollToSection('attendanceSection')">Mark Attendance</button>
    <button onclick="scrollToSection('recordsSection')">View Records</button>
    <button onclick="window.location.href='registration_form.php'">Registration</button>
    <button class="logout-btn" onclick="logout()">Logout</button>
  </div>

  <!-- Scanner Section -->
  <div class="scanner-container">
    <h2>🔍 Live QR Code Scanner</h2>
    <div id="reader"></div>
    <div id="result">Result: <span id="qr-result">None</span></div>
    <button class="scan-btn" onclick="stopScanner()">Stop Scanner</button>
  </div>

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

    const qrResult = document.getElementById("qr-result");
    let scanner;
    let scannedIds = [];

    function startScanner() {
      scanner = new Html5Qrcode("reader");
      const config = {
        fps: 10,
        qrbox: { width: 250, height: 250 },
        rememberLastUsedCamera: true
      };
      scanner.start(
        { facingMode: "environment" },
        config,
        qrCodeMessage => check_qr(qrCodeMessage),
        error => {}
      ).catch(err => {
        console.error("Start scanner failed:", err);
      });
    }

    function check_qr(msg) {
      const parts = msg.split("&&");
      const unique_code = parts[0];
      const date = parts[1];
      const time = parts[2];
      const now = new Date();

      const [day, month, year] = date.split(",");
      const [hour, minute] = time.split(",");

      if (!unique_code) return;

      if (now.getDate() == day && (now.getMonth() + 1) == month && now.getFullYear() == year) {
        if (now.getHours() == hour &&
            (minute == now.getMinutes()-1 || minute == now.getMinutes() || minute == now.getMinutes()+1)) {
          if (!scannedIds.includes(unique_code)) {
            scannedIds.push(unique_code);
            qrResult.innerText = unique_code;
            sendToServer(unique_code);
          }
        }
      }
    }

    function sendToServer(code) {
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "save_login.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send("unique_code=" + encodeURIComponent(code));
    }

    function stopScanner() {
      if (scanner) {
        scanner.stop().then(() => {
          console.log("Scanner stopped.");
        }).catch(err => {
          console.error("Stop failed:", err);
        });
      }
    }

    window.addEventListener("load", startScanner);
  </script>
</body>
</html>
