<?php
    include 'db.php';

    $doctor = $_GET['doctor'];
    $date = $_GET['date'];

    $stmt = $conn->prepare("SELECT appointment_time FROM appointments WHERE doctor_name = ? AND appointment_date = ?");
    $stmt->bind_param("ss", $doctor, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    $booked_times = [];
    while ($row = $result->fetch_assoc()) {
        $booked_times[] = $row['appointment_time'];
    }
    $stmt->close();
    $conn->close();

    echo json_encode($booked_times);
?>
