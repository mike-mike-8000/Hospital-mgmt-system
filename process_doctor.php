<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctorId = $_POST['doctor_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE doctors SET is_approved = 1 WHERE id = ?");
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
    } elseif ($action === 'reject') {
        $stmt = $conn->prepare("DELETE FROM doctors WHERE id = ?");
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
    }

    header("Location: admin_panel.php");
    exit();
}
?>
