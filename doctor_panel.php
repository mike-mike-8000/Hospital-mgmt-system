<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['doctor_name'])) {
    header("Location: doctor_login.html");
    exit();
}

include 'db.php'; // Ensure database connection is included

$doctorName = $_SESSION['doctor_name'];

// Fetch doctor details from DB
$stmt = $conn->prepare("SELECT * FROM doctors WHERE CONCAT(fname, ' ', lname) = ?");
$stmt->bind_param("s", $doctorName);
$stmt->execute();
$docResult = $stmt->get_result();
$doctorInfo = $docResult->fetch_assoc();


// Fetch new (Pending) appointments
$stmt = $conn->prepare("SELECT * FROM appointments WHERE doctor_name = ? AND status = 'Pending' ORDER BY appointment_date ASC");
$stmt->bind_param("s", $doctorName);
$stmt->execute();
$result = $stmt->get_result();

$newAppointments = [];
while ($row = $result->fetch_assoc()) {
    $newAppointments[] = $row;
}

// Fetch all appointments for this doctor
$stmtAll = $conn->prepare("SELECT * FROM appointments WHERE doctor_name = ? ORDER BY appointment_date DESC, appointment_time DESC");
$stmtAll->bind_param("s", $doctorName);
$stmtAll->execute();
$resultAll = $stmtAll->get_result();

$allAppointments = [];
while ($row = $resultAll->fetch_assoc()) {
    $allAppointments[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Doctor Panel - Hospital Booking</title>
  <link rel="icon" href="images/my_favicon.jpeg" type="image/x-icon">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f0faff;
    }

    .navbar {
      background-color: #2196F3;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      flex-wrap: wrap;
    }

    .navbar h2 {
      color: white;
      margin: 0;
    }

    .navbar ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      flex-wrap: wrap;
    }

    .navbar ul li {
      margin-left: 20px;
    }

    .navbar ul li a {
      color: white;
      text-decoration: none;
      font-size: 18px;
      padding: 10px 15px;
      border-radius: 5px;
      transition: 0.3s;
    }

    .navbar ul li a:hover {
      background-color: #1976D2;
    }

    .navbar ul li a.logout:hover {
      background-color: #f44336;
    }

    .content {
      padding: 30px;
    }

    h2 {
      color: #1976D2;
    }

    section {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 25px;
    }

    .card {
      padding: 15px;
      background-color: #E3F2FD;
      border-left: 5px solid #2196F3;
      margin-top: 10px;
    }

    .card p {
      margin: 5px 0;
    }

    form label {
      display: block;
      margin-top: 10px;
    }

    form input,
    form button,
    form select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    form button {
      background-color: #2196F3;
      color: white;
      border: none;
      margin-top: 15px;
      cursor: pointer;
      transition: background 0.3s;
    }

    form button:hover {
      background-color: #1976D2;
    }

    ul {
      padding-left: 20px;
    }

    ul li {
      margin-bottom: 5px;
    }

    .remove-slot {
      background-color: #f44336;
      color: white;
      border: none;
      padding: 8px 14px;
      margin-top: 10px;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .remove-slot:hover {
      background-color: #d32f2f;
    }

    @media (max-width: 768px) {
      .navbar {
        flex-direction: column;
        align-items: flex-start;
      }

      .navbar ul {
        flex-direction: column;
        width: 100%;
        margin-top: 10px;
      }

      .navbar ul li {
        margin-left: 0;
        margin-bottom: 10px;
      }

      .navbar ul li a {
        display: block;
        width: 100%;
      }

      .content {
        padding: 15px;
      }

      form input,
      form button,
      form select {
        font-size: 16px;
      }
    }
  </style>
</head>
<body>

  <!-- Navigation -->
  <nav class="navbar">
    <h2>Welcome, <?php echo htmlspecialchars($doctorName); ?></h2>
    <ul>
      <li><a href="#notifications">Appointments</a></li>
      <li><a href="#view-appointments">View All</a></li>
      <li><a href="#profile">Profile</a></li>
      <li><a href="#" class="logout" onclick="confirmLogout()">Logout</a></li>
    </ul>
  </nav>

  <main class="content">
  
   <!-- Profile Section Placeholder -->
   <section id="profile">
      <h2>👨‍⚕️ Profile</h2>
      <?php if ($doctorInfo): ?>
        <div class="card">
          <p><strong>Full Name:</strong> <?php echo htmlspecialchars($doctorInfo['fname'] . ' ' . $doctorInfo['lname']); ?></p>
          <p><strong>Email:</strong> <?php echo htmlspecialchars($doctorInfo['email']); ?></p>
          <p><strong>Phone:</strong> <?php echo htmlspecialchars($doctorInfo['phone']); ?></p>
          <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($doctorInfo['dob']); ?></p>
          <p><strong>Specialty:</strong> <?php echo htmlspecialchars($doctorInfo['specialty']); ?></p>
          <p><strong>Gender:</strong> <?php echo htmlspecialchars($doctorInfo['gender']); ?></p>
        </div>
      <?php else: ?>
        <p>Unable to fetch profile info.</p>
      <?php endif; ?>
    </section>

    <!-- Notifications -->
    <section id="notifications">
      <h2>🔔 New Appointments</h2>
      <?php if (count($newAppointments) > 0): ?>
        <?php foreach ($newAppointments as $appointment): ?>
          <div class="card">
            <p><strong>New Appointment:</strong> <?php echo htmlspecialchars($appointment['patient_name']); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($appointment['appointment_date']); ?></p>
            <p><strong>Time:</strong> <?php echo htmlspecialchars($appointment['appointment_time']); ?></p>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="card">
          <p>No new appointments.</p>
        </div>
      <?php endif; ?>
    </section>

    <!-- View All Appointments -->
    <section id="view-appointments">
      <h2>📅 View All Appointments</h2>
      <?php if (count($allAppointments) > 0): ?>
        <?php foreach ($allAppointments as $app): ?>
          <div class="card">
            <p><strong>Patient:</strong> <?= htmlspecialchars($app['patient_name']); ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($app['appointment_date']); ?></p>
            <p><strong>Time:</strong> <?= htmlspecialchars($app['appointment_time']); ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($app['status']); ?></p>
            <p><strong>Created At:</strong> <?= htmlspecialchars($app['created_at']); ?></p>
            
            <!-- Action buttons -->
            <form action="edit_appointment.php" method="POST" style="display: inline;">
              <input type="hidden" name="id" value="<?= $app['id']; ?>">
              <button type="submit">Edit</button>
            </form>

            <form action="delete_appointment.php" method="POST" style="display: inline;" onsubmit="return confirm('Delete this appointment?');">
              <input type="hidden" name="id" value="<?= $app['id']; ?>">
              <button type="submit" style="background-color:#f44336;color:white;">Delete</button>
            </form>
          </div>
        <?php endforeach; ?>

      <?php else: ?>
        <div class="card">
          <p>No appointments found.</p>
        </div>
      <?php endif; ?>
    </section>



  </main>

  <script>
    function confirmLogout() {
      if (confirm("Are you sure you want to log out?")) {
        window.location.href = "logout.php";
      }
    }
  </script>

</body>
</html>
