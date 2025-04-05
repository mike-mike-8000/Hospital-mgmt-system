<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['doctor_name'])) {
    header("Location: doctor_login.html");
    exit();
}

$doctorName = $_SESSION['doctor_name'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Doctor Panel - Hospital Booking</title>
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

    /* Remove Slot Button */
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

    /* Responsive Design */
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
      <li><a href="#appointments">Appointments</a></li>
      <li><a href="#profile">Profile</a></li>
      <li><a href="#" class="logout" onclick="confirmLogout()">Logout</a></li>
    </ul>
  </nav>

  <main class="content">

    <!-- Notifications -->
    <section id="notifications">
      <h2>🔔 Notifications</h2>
      <div class="card">
        <p><strong>New Appointment:</strong> You have a new appointment scheduled with Samir Khan on March 24, 2025 at 11:30 AM.</p>
      </div>
      <div class="card">
        <p><strong>Upcoming Appointment Reminder:</strong> Appointment with Jordan Lee is tomorrow at 10:00 AM.</p>
      </div>
    </section>
  
    <!-- View Appointments -->
    <section id="view-appointments">
      <h2>📅 View Appointments</h2>
      <div class="card">
        <p><strong>Patient:</strong> Jordan Lee</p>
        <p><strong>Date:</strong> March 26, 2025</p>
        <p><strong>Time:</strong> 10:00 AM</p>
        <p><strong>Reason:</strong> Chest Pain Consultation</p>
      </div>
      <div class="card">
        <p><strong>Patient:</strong> Samir Khan</p>
        <p><strong>Date:</strong> March 24, 2025</p>
        <p><strong>Time:</strong> 11:30 AM</p>
        <p><strong>Reason:</strong> Blood Pressure Follow-up</p>
      </div>
    </section>
  
    <!-- Modify Appointments -->
    <section id="modify-appointments">
      <h2>✏️ Modify Appointment</h2>
      <form>
        <label for="appointment-id">Select Appointment:</label>
        <select id="appointment-id" name="appointment-id">
          <option value="appt1">Jordan Lee - March 26, 2025 @ 10:00 AM</option>
          <option value="appt2">Samir Khan - March 24, 2025 @ 11:30 AM</option>
        </select>
  
        <label for="new-date">New Date:</label>
        <input type="date" id="new-date" name="new-date" />
  
        <label for="new-time">New Time:</label>
        <input type="time" id="new-time" name="new-time" />
  
        <button type="submit">Update Appointment</button>
      </form>
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
