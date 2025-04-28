  var adminUsername = "admin";
  var adminPassword = "admin123";
  var loginContainer = document.getElementById("loginContainer");
  // var dashboard = document.getElementById("dashboard");
  // var recordsTable = document.getElementById("recordsTable").querySelector("tbody");
  var sideMenu = document.getElementById("sideMenu");
    var nav_bar = document.getElementById("nav_bar")


      

  function logout() {
  dashboard.classList.add("hidden");
  loginContainer.classList.remove("hidden");
  sideMenu.classList.remove("show");
  document.getElementById("navbarContainer").classList.add("hidden");
}


  // function markAttendance() {
  //   var name = document.getElementById("studentName").value.trim();
  //   var status = document.getElementById("status").value;
  //   var date = new Date().toLocaleDateString();

  //   if (name === "") {
  //     alert("Please enter student name.");
  //     return;
  //   }

  //   var row = recordsTable.insertRow();
  //   row.insertCell(0).innerText = name;
  //   row.insertCell(1).innerText = status;
  //   row.insertCell(2).innerText = date;

  //   document.getElementById("studentName").value = "";
  // }

  function toggleMenu() {
    document.getElementById("sideMenu").classList.add("show");
  }
  
  function cuts() {
    document.getElementById("sideMenu").classList.remove("show");
  }
  
  
  function scrollToSection(id) {
    document.getElementById(id).scrollIntoView({ behavior: 'smooth' });
    toggleMenu();
  }
  
  function refreshPage() {
    const refreshIcon = document.getElementById("refresh");
      refreshIcon.classList.add("spin");
    setTimeout(() => {
      refreshIcon.classList.remove("spin");
      location.reload(); 
    }, 600); 
  }
  