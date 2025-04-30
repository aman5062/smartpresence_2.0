<?php
include_once("assets/html/db.php");
if (isset($_SESSION['user'])=="active") {
  // No teacher_code in session, redirect to login page
  header('Location: assets/html/home.php');
  exit();
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Login</title>
  <style>
    * {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

:root {
  --primary-color: #3b82f6;
  --primary-hover: #2563eb;
  --background-color: #f3f4f6;
  --container-bg: #eddada;
  --input-bg: #f9fafb;
  --input-border: #d1d5db;
  --font: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  --radius: 12px;
  --transition-speed: 0.3s;
}

/* Body Styling */
body {
  font-family: var(--font);
  background: linear-gradient(to right, #85ade7, #326dec);
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1rem;
}

/* Container */
.login-container {
  width: 100%;
  max-width: 420px;
  background-color: var(--container-bg);
  padding: 2.5rem 2rem;
  border-radius: var(--radius);
  box-shadow: var(--box-shadow);
  animation: slideFade 0.8s ease forwards;
  opacity: 0;
  transform: translateY(20px);
  transition: transform var(--transition-speed), box-shadow var(--transition-speed);
}

.login-container:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

/* Heading */
h2 {
  text-align: center;
  margin-bottom: 1.8rem;
  color: #111827;
  font-weight: 600;
  font-size: 1.8rem;
  letter-spacing: 0.5px;
}

/* Inputs */
input {
  width: 100%;
  padding: 0.85rem;
  margin: 10px 0;
  border: 1px solid var(--input-border);
  border-radius: 8px;
  background: var(--input-bg);
  font-size: 1rem;
  transition: all var(--transition-speed);
}

input:focus {
  outline: none;
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
  background-color: #fff;
}

/* Button */
button {
  width: 50%;
  padding: 0.85rem;
  margin-top: 14px;
margin-left: 5rem;
  background-color: var(--primary-color);
  color: white;
  border: none;
  border-radius: 10px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  transition: transform 0.2s ease, box-shadow 0.3s ease;
  animation: bounceIn 0.7s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

button::before {
  content: '';
  position: absolute;
  top: 0;
  left: -75%;
  width: 50%;
  height: 100%;
  background: rgba(255, 255, 255, 0.3);
  transform: skewX(-25deg);
  transition: 0.5s;
}

button:hover::before {
  left: 100%;
}

button:hover {
  background-color: var(--primary-hover);
  transform: scale(1.05);
  box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
}

button:active {
  transform: scale(0.96);
  box-shadow: inset 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* The alert message box */
.alert {
  padding: 20px;
  background-color: #f44336; /* Red */
  color: white;
  margin-bottom: 15px;
}

/* The close button */
.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}

.alert {
  opacity: 1;
  transition: opacity 0.6s; 
}

/* Responsive */
@media (max-width: 600px) {
  .login-container {
    padding: 2rem 1.5rem;
  }

  input, button {
    font-size: 1rem;
  }
}

/* Animations */
@keyframes slideFade {
  0% {
    opacity: 0;
    transform: translateY(20px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

  </style>
</head>
<body>

  <div class="login-container" id="loginContainer">
    <h2>User Login</h2>
    <form method="POST" action="assets/html/login_check.php">
      <input type="text" id="enrollment" name="enrollment" placeholder="Enrollment no." required />
      <input type="password" id="password" name="password" placeholder="Password" required />
      
      <button type="submit">Login</button>
    </form>
  </div>

  
</body>
</html>
