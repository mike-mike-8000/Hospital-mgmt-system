<?php
require_once 'db.php'; // DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM doctors WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $doctor = $result->fetch_assoc();

        // Check approval status before verifying password
        if ($doctor['is_approved'] == 0) {
            echo "<script>alert('Your account is still pending approval from the admin.'); window.location.href='doctor_login.html';</script>";
            exit();
        } elseif ($doctor['is_approved'] == -1) {
            echo "<script>alert('Your registration has been rejected or your Account has been disabled. Please see the admin.'); window.location.href='doctor_login.html';</script>";
            exit();
        }

        // Verify password
        if (password_verify($password, $doctor['password'])) {
            session_start();
            $_SESSION['doctor_name'] = $doctor['fname'] . " " . $doctor['lname'];
            echo "<script>alert('Login successful!'); window.location.href='doctor_panel.php';</script>";
            exit();
        } else {
            echo "<script>alert('Invalid password.'); window.location.href='doctor_login.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Doctor with this email not found.'); window.location.href='doctor_login.html';</script>";
        exit();
    }
}
?>

