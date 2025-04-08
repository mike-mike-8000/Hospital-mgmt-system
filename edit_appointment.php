<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Fetch appointment
    $stmt = $conn->prepare("SELECT * FROM appointments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointment = $result->fetch_assoc();

    if (!$appointment) {
        echo "Appointment not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit Appointment</title></head>
<body>
<h2>Edit Appointment</h2>

<form action="update_appointment.php" method="POST">
  <input type="hidden" name="id" value="<?= $appointment['id']; ?>">

  <label>Date:</label>
  <input type="date" name="appointment_date" value="<?= $appointment['appointment_date']; ?>" required><br><br>

  <label>Time:</label>
  <input type="time" name="appointment_time" value="<?= $appointment['appointment_time']; ?>" required><br><br>

  <label>Status:</label>
  <select name="status">
    <option value="Pending" <?= $appointment['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
    <option value="Approved" <?= $appointment['status'] === 'Approved' ? 'selected' : ''; ?>>Approved</option>
    <option value="Completed" <?= $appointment['status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
    <option value="Cancelled" <?= $appointment['status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
  </select><br><br>

  <button type="submit">Update Appointment</button>
</form>
</body>
</html>
