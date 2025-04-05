<?php
session_start(); // Start a session to store user data after login

// Include your database connection file
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input data from the login form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prevent SQL injection by using prepared statements
    $sql = "SELECT * FROM patients WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // Fetch the user data from the database
        $user = $result->fetch_assoc();

        // Verify the password (assuming password is hashed in the database)
        if (password_verify($password, $user['password'])) {
            // Password is correct, start a session and redirect to the patient panel
            $_SESSION['patient_id'] = $user['id']; // Store user id in session
            $_SESSION['patient_email'] = $user['email']; // Store email in session
            header("Location: patient_panel.php");
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Incorrect password. Please try again.'); window.location.href='patient_login.html';</script>";
        }
    } else {
        // No user found with the given email
        echo "<script>alert('No account found with that email.'); window.location.href='login.html';</script>";
    }

    $stmt->close();
}
?>
