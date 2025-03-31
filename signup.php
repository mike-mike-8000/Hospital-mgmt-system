<?php
include 'db.php';

header("Content-Type: application/json"); // Ensure correct JSON response

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = isset($_POST["fname"]) ? trim($_POST["fname"]) : null;
    $lname = isset($_POST["lname"]) ? trim($_POST["lname"]) : null;
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : null;
    $phone = isset($_POST["phone"]) ? trim($_POST["phone"]) : null;
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : null;
    $password = isset($_POST["password"]) ? $_POST["password"] : null;

    if (!$fname || !$lname || !$email || !$phone || !$gender || !$password) {
        echo json_encode(["status" => "error", "message" => "All fields are required"]);
        exit();
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if email exists
    $checkEmail = $conn->prepare("SELECT id FROM patients WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email already registered"]);
        exit();
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO patients (first_name, last_name, email, phone, gender, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $fname, $lname, $email, $phone, $gender, $hashedPassword);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Signup successful!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error"]);
    }

    $stmt->close();
    $conn->close();
}
?>