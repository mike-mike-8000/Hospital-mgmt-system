<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $date = $_POST['appointment_date'];
    $time = $_POST['appointment_time'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE appointments SET appointment_date = ?, appointment_time = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sssi", $date, $time, $status, $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Appointment updated successfully.');
            window.location.href = 'doctor_panel.php';
        </script>";
        exit();
    } else {
        echo "Failed to update.";
    }
} else {
    echo "Invalid request.";
}
?>
