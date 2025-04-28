<?php
include 'db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'] ?? '';
    $class = $_POST['class'] ?? '';
    $section = $_POST['section'] ?? '';
    $enrollment = $_POST['enrollment'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $teacher_code = $_SESSION['teacher_code']; 
    $unique_code = generateUniqueCode(); 
    $password = ''; 

    $photoFileName = '';

    // Upload photo
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photoTmp = $_FILES['photo']['tmp_name'];
        $photoFileName = uniqid() . '_' . basename($_FILES['photo']['name']);
        $targetPath = $uploadDir . $photoFileName;

        if (!move_uploaded_file($photoTmp, $targetPath)) {
            echo "Failed to upload photo.";
            exit;
        }
    } else {
        echo "Photo upload error.";
        exit;
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO `user` 
    (Name, Class, sec, Enrollment_no, Email, phone_no, unique_code, Teacher_code, Image, Password) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssss", 
      $name, $class, $section, $enrollment, $email, $phone, 
      $unique_code, $teacher_code, $photoFileName, $password);

    if ($stmt->execute()) {
        // Send email to the user with a password reset link
        sendPasswordResetEmail($email, $unique_code);

        echo "Student registered. A password reset link has been sent to their email.";
    } else {
        echo "Database error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}

// Function to generate unique code
function generateUniqueCode() {
    global $conn;
    $unique_code = uniqid("U_");
    
    // Check if the code already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM `user` WHERE `unique_code` = ?");
    $stmt->bind_param("s", $unique_code);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // If the code already exists, generate a new one
    if ($count > 0) {
        return generateUniqueCode(); // Recursively regenerate unique code
    }

    return $unique_code;
}

// Function to send password reset email
function sendPasswordResetEmail($email, $unique_code) {
    $resetLink = "http://yourdomain.com/reset_password.php?code=" . $unique_code;

    $subject = "Password Reset Request";
    $message = "Hello, \n\nYou have successfully registered. To set your password, please click the following link: \n\n" . $resetLink;
    $headers = "From: no-reply@yourdomain.com";

    mail($email, $subject, $message, $headers);
}
?>