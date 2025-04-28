<?php
include_once("db.php");
if (!isset($_SESSION['user'])=="active") {
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
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <div class="navbar hidden" id="navbarContainer">
    <div class="com_nav">
      <div class="l_nav"><h3>User Portal</h3></div>
      <div class="r_nav">
        <button>Attendance</button>
        <button>View Records</button>
        <button class="logout-btn" onclick="logout()">Logout</button>
      </div>
    </div>
    <div class="menu-icon" onclick="toggleMenu()">
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>
   
  <div class="side-menu" id="sideMenu">
    <div id="cut" onclick="cuts()"><i class="fa-solid fa-xmark"></i></div>
    <div id="refresh" onclick="refreshPage()"><i class="fa-solid fa-rotate-right"></i></div>
  
    <div class="side-content">
      <!-- QR Code Section -->
      <div style="position: relative; width: 30vh; height: 30vh; margin: 0 auto;">
        <div id="qrcode"></div>
        <img src="assets/image.png" id="image"
             style="position: absolute; top: 59%; left: 58%; width: 42px; height: 42px; transform: translate(-50%, -50%); border-radius: 8px;">
      </div>
<div class="side">
  <button onclick="scrollToSection('attendanceSection')">Attendance</button>
      <button onclick="scrollToSection('recordsSection')">View Records</button>
      <button onclick="logout()" class="logout-btn">Logout</button>
</div>
      
    </div>
  </div>

  <section id="recordsSection">
    <h3>Attendance Records</h3>
    <table id="recordsTable">
      <thead>
        <tr>
          <th>Student</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </section>

  <script src="../js/script.js"></script>
  <script>
    // Set the profile image
    document.getElementById("image").src = "../../../Admins/assets/html/uploads/<?php echo $_SESSION['image']; ?>";

    function generateQR() {
      const now = new Date();
      const date = now.getDate() + "," + (now.getMonth() + 1) + "," + now.getFullYear();
      const time = now.getHours() + "," + now.getMinutes();
      var code = "<?php echo $_SESSION["unique_id"]; ?>";
      
      
      const qrText = code +"&&"+date+"&&"+time;
      const qrContainer = document.getElementById("qrcode");

      qrContainer.innerHTML = "";

      new QRCode(qrContainer, {
        text: qrText,
        width: 198,
        height: 198,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
      });
      lastGeneratedMinute = now.getMinutes();
    }

    
    generateQR();

    setInterval(() => {
  const now = new Date();
  const currentMinute = now.getMinutes();

  if (currentMinute !== lastGeneratedMinute) {
    generateQR();
  }
}, 1000);
    function scrollToSection(id) {
      const section = document.getElementById(id);
      if (section) section.scrollIntoView({ behavior: "smooth" });
    }
  </script>
</body>
</html>
