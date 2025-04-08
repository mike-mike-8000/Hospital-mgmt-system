<?php
session_start();
include 'db.php'; // Connect to DB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check credentials
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && $admin['password'] === $password) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['username'];
        header("Location: admin_panel.php");
        exit();
    } else {
        echo "<script>alert('Invalid username or password'); window.location.href='admin_login.html';</script>";
    }
} else {
    header("Location: admin_login.html");
    exit();
}
?>
