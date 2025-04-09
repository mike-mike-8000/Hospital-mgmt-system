<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.html");
    exit();
}

// Fetch pending doctors
$pendingDoctors = $conn->query("SELECT * FROM doctors WHERE is_approved = 0");

// Fetch approved doctors
$approvedDoctors = $conn->query("SELECT * FROM doctors WHERE is_approved = 1");
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel - SerenityHospital</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f8f9fa;
    }

    nav {
      background: white;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    nav h1 {
      margin: 0;
      color: #333;
    }

    nav a {
      margin-left: 20px;
      text-decoration: none;
      color: #333;
      font-weight: bold;
    }

    .container {
      padding: 2rem;
    }

    h2 {
      margin-top: 2rem;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }

    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background: #e9ecef;
    }

    button {
      padding: 6px 12px;
      border: none;
      background: #28a745;
      color: white;
      border-radius: 4px;
      cursor: pointer;
    }

    button.reject {
      background: #dc3545;
    }
  </style>
</head>
<body>

  <nav>
    <h1>Admin Panel</h1>
    <div>
      <a href="#">Dashboard</a>
      <a href="adm_logout.php">Logout</a>
    </div>
  </nav>

  <div class="container">

    <h2>Pending Doctor Approvals</h2>
    <table>
        <?php while ($row = $pendingDoctors->fetch_assoc()): ?>
    <tr>
      <td>Dr. <?= htmlspecialchars($row['fname'] . ' ' . $row['lname']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['specialty']) ?></td>
      <td>
        <form action="process_doctor.php" method="post" style="display:inline;">
          <input type="hidden" name="doctor_id" value="<?= $row['id'] ?>">
          <input type="hidden" name="action" value="approve">
          <button type="submit">Approve</button>
        </form>
        <form action="process_doctor.php" method="post" style="display:inline;">
          <input type="hidden" name="doctor_id" value="<?= $row['id'] ?>">
          <input type="hidden" name="action" value="reject">
          <button type="submit" class="reject">Reject</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
    </table>


    <h2>Approved Doctors</h2>
    <table>
      <?php while ($row = $approvedDoctors->fetch_assoc()): ?>
      <tr>
        <td>Dr. <?= htmlspecialchars($row['fname'] . ' ' . $row['lname']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['specialty']) ?></td>
        <td>Approved</td>
      </tr>
      <?php endwhile; ?>
    </table>

  </div>

  <script>
  // Approve confirmation
    document.querySelectorAll("form[action='process_doctor.php']").forEach(form => {
      form.addEventListener("submit", function (e) {
        const actionType = this.querySelector("input[name='action']").value;
        let message = "";

        if (actionType === "approve") {
          message = "Are you sure you want to approve this doctor?";
        } else if (actionType === "reject") {
          message = "Are you sure you want to reject and remove this doctor?";
        }

        if (!confirm(message)) {
          e.preventDefault(); // Stop the form submission
        }
      });
    });
  </script>

</body>
</html>
