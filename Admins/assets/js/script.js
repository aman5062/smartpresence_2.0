var adminUsername = "admin";
var adminPassword = "admin123";
var loginContainer = document.getElementById("loginContainer");
var dashboard = document.getElementById("dashboard");
var sideMenu = document.getElementById("sideMenu");
  var nav_bar = document.getElementById("nav_bar");
  var cut = document.getElementById("cut");

  // function login() {
  //     const user = document.getElementById("username").value;
  //     const pass = document.getElementById("password").value;
    
  //     if (user === adminUsername && pass === adminPassword) {
  //       loginContainer.classList.add("hidden");
  //       dashboard.classList.remove("hidden");
  //       // document.getElementById("navbarContainer").classList.remove("hidden");
  //     } else {
  //       alert("Invalid credentials!");
  //     }
  //   }
    

function logout() {
window.location = "../html/logout.php";
}


function markAttendance() {
  var name = document.getElementById("studentName").value.trim();
  var status = document.getElementById("status").value;
  var date = new Date().toLocaleDateString();

  if (name === "") {
    alert("Please enter student name.");
    return;
  }

  var row = recordsTable.insertRow();
  row.insertCell(0).innerText = name;
  row.insertCell(1).innerText = status;
  row.insertCell(2).innerText = date;

  document.getElementById("studentName").value = "";
}

// function toggleMenu() {
//   sideMenu.classList.toggle("show");

// }
function toggleMenu() {
  const sideMenu = document.getElementById('sideMenu');
  sideMenu.classList.toggle('show');
}

function closeMenu() {
  const sideMenu = document.getElementById('sideMenu');
  sideMenu.classList.remove('show');
}

function scrollToSection(id) {
  document.getElementById(id).scrollIntoView({ behavior: 'smooth' });
  toggleMenu();
}
function locat(){
  window.location.href = "registration_form.html";
}
