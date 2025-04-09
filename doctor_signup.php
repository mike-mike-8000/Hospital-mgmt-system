<?php
require_once 'db.php'; // include your DB connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data safely
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $dob = $_POST['dob'];
    $specialty = $_POST['specialty'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM doctors WHERE email = ? AND is_approved = 0"; // Prevent re-adding unapproved doctor
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already registered and awaiting approval!'); window.location.href='doctor_register.html';</script>";
        exit();
    }

    // Insert new doctor (pending approval)
    $sql = "INSERT INTO doctors (fname, lname, email, phone, dob, specialty, gender, password, is_approved)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)"; // Default to 0 (pending)

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $fname, $lname, $email, $phone, $dob, $specialty, $gender, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>alert('Account successfully created! Pending admin approval.'); window.location.href='doctor_login.html';</script>";
        exit();
    } else {
        echo "<script>alert('Registration failed. Please try again.'); window.location.href='doctor_register.html';</script>";
        exit();
    }
}
?>
