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
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Live QR Code Scanner</title>
  <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
  <style>
    body {
      font-family: sans-serif;
      background: #f9f9f9;
      text-align: center;
      padding: 30px;
    }
    #reader {
      width: 400px;
      max-width: 90vw;
      margin: auto;
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    #result {
      margin-top: 20px;
      font-size: 18px;
      color: green;
    }
    #errorLog {
      color: #999;
      font-size: 12px;
      margin-top: 10px;
    }
    button {
      margin: 10px;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <h2>🔍 Live QR Code Scanner</h2>
  <div id="reader"></div>
  <div id="result">Result: <span id="qr-result">None</span></div>
  <div id="errorLog"></div>
  <button onclick="stopScanner()">Stop</button>

  <script>
    let scanner;
    let scannedIds = [];

    const qrResult = document.getElementById("qr-result");
    const errorLog = document.getElementById("errorLog");

    function startScanner() {
      const config = {
        fps: 10,
        qrbox: { width: 300, height: 300 },
        rememberLastUsedCamera: true,
        supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
      };

      scanner = new Html5Qrcode("reader");

      scanner.start(
        { facingMode: "environment" },
        config,
        qrCodeMessage => {
          check_qr(qrCodeMessage);
        },
        error => {
          errorLog.innerText = `Looking...`;
        }
      ).catch(err => {
        errorLog.innerText = "❌ Error: " + err;
        console.error("Camera start error:", err);
      });
    }

    function check_qr(msg){
      const parts = msg.split("&&");
      const unique_code = parts[0];
      const date = parts[1];
      const time = parts[2];
      const now = new Date();

      if (!unique_code) {
        console.log("Unique code blank");
        return;
      }

      if (now.getDate() == date.split(",")[0] && now.getMonth()+1==date.split(",")[1] && now.getFullYear()==date.split(",")[2]) {
        if (now.getHours() == time.split(",")[0]) {
          if (time.split(",")[1] == now.getMinutes()-1 || time.split(",")[1] == now.getMinutes() || time.split(",")[1] == now.getMinutes()+1) {
            if (scannedIds.includes(unique_code)) {
              console.log("⚠️ Already scanned this code!");
            } else {
              scannedIds.push(unique_code);
              qrResult.innerText = unique_code;
              sendToServer(unique_code);
            }
          } else {
            console.log("Time not matched");
          }
        } else {
          console.log("Hour not matched");
        }
      } else {
        console.log("Date not matched");
      }
    }

    function sendToServer(unique_code) {
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "save_login.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      xhr.onload = function() {
        if (this.status == 200) {
          console.log(this.responseText); // Show server response
        }
      };

      xhr.send("unique_code=" + encodeURIComponent(unique_code));
    }

    function stopScanner() {
      if (scanner) {
        scanner.stop().then(() => {
          console.log("🔴 Scanner stopped");
        }).catch(err => {
          console.error("Failed to stop:", err);
        });
      }
    }

    window.addEventListener("load", startScanner);
  </script>

</body>
</html>
