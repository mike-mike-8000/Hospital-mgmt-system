<?php
session_start();
include 'db.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: index.html");
    exit();
}

$patient_id = $_SESSION['patient_id'];
$department = $_POST['department'];
$doctor = $_POST['doctor'];
$date = $_POST['date'];
$time = $_POST['time'];

// Fetch patient's name
$stmt = $conn->prepare("SELECT first_name, last_name FROM patients WHERE id = ?");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$stmt->bind_result($fname, $lname);
$stmt->fetch();
$patient_name = $fname . ' ' . $lname;
$stmt->close();

// Check if appointment already exists for doctor, date and time
$stmt = $conn->prepare("SELECT id FROM appointments WHERE doctor_name = ? AND appointment_date = ? AND appointment_time = ?");
$stmt->bind_param("sss", $doctor, $date, $time);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['error'] = "Selected time is already booked. Please choose another.";
    header("Location: patient_panel.php");
    exit();
}
$stmt->close();

// Insert appointment
$stmt = $conn->prepare("INSERT INTO appointments (patient_id, patient_name, doctor_name, department, appointment_date, appointment_time, status, created_at) VALUES (?, ?, ?, ?, ?, ?, 'Pending', NOW())");
$stmt->bind_param("isssss", $patient_id, $patient_name, $doctor, $department, $date, $time);
if ($stmt->execute()) {
    $_SESSION['success'] = "Appointment successfully booked!";
} else {
    $_SESSION['error'] = "Failed to book appointment.";
}
$stmt->close();
$conn->close();

header("Location: patient_panel.php");
exit();
?>
