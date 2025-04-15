<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $action = $_POST['action'];

    switch ($action) {
        case 'approve':
            $status = 1;
            break;
        case 'reject':
            $status = -1;
            break;
        case 'disable':
            $status = -1;
            break;
        case 'enable':
            $status = 1;
            break;
        default:
            header("Location: admin_panel.php");
            exit();
    }

    $stmt = $conn->prepare("UPDATE doctors SET is_approved = ? WHERE id = ?");
    $stmt->bind_param("ii", $status, $id);

    if ($stmt->execute()) {
        header("Location: admin_panel.php");
        exit();
    } else {
        echo "Failed to update status.";
    }
}
?>