<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: doctor_panel.php");
    exit();
} else {
    echo "Invalid request.";
}
