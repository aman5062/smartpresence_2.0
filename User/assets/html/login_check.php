<?php
include_once("db.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enrollment = $_POST['enrollment'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($enrollment) || empty($password)) {
        echo "Please enter both Enrollment Number and Password.";
        exit;
    }
    $stmt = $conn->prepare("SELECT * FROM `user` WHERE `Enrollment_no` = ?");
    $stmt->bind_param("s", $enrollment);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (!empty($user['Password']) && md5($password) === $user['Password']
        ) {
            
            $_SESSION['unique_id'] = $user['unique_code'];  // or any unique ID
            $_SESSION['enrollment'] = $user['Enrollment_no'];
            $_SESSION['image'] = $user['Image'];
            $_SESSION['user'] = "active";
            header("Location: home.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that enrollment number.";
    }

    $stmt->close();
    $conn->close();
}
?>
