<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.html");
    exit();
}

// Fetch doctors by approval status
$pendingQuery = "SELECT * FROM doctors WHERE is_approved = 0";
$approvedQuery = "SELECT * FROM doctors WHERE is_approved = 1";
$disabledQuery = "SELECT * FROM doctors WHERE is_approved = -1";

$pendingDoctors = $conn->query($pendingQuery);
$approvedDoctors = $conn->query($approvedQuery);
$disabledDoctors = $conn->query($disabledQuery);
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

    form {
      display: inline;
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

    button.disable {
      background: #ffc107;
      color: #000;
    }

    button.enable {
      background: #007bff;
    }
  </style>

  <script>
    function confirmAction(message, form) {
      if (confirm(message)) {
        form.submit();
      }
    }
  </script>
  <link rel="icon" href="images/my_favicon.jpeg" type="image/x-icon">
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

    <!-- Pending -->
    <h2>Pending Doctor Approvals</h2>
    <table>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Specialization</th>
        <th>Actions</th>
      </tr>
      <?php while ($row = $pendingDoctors->fetch_assoc()): ?>
      <tr>
        <td>Dr. <?= htmlspecialchars($row['fname'] . ' ' . $row['lname']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['specialty']) ?></td>
        <td>
          <form method="post" action="doctor_action.php" onsubmit="event.preventDefault(); confirmAction('Approve this doctor?', this);">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="action" value="approve">
            <button>Approve</button>
          </form>
          <form method="post" action="doctor_action.php" onsubmit="event.preventDefault(); confirmAction('Reject this doctor?', this);">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="action" value="reject">
            <button class="reject">Reject</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>

    <!-- Approved -->
    <h2>Approved Doctors</h2>
    <table>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Specialization</th>
        <th>Actions</th>
      </tr>
      <?php while ($row = $approvedDoctors->fetch_assoc()): ?>
      <tr>
        <td>Dr. <?= htmlspecialchars($row['fname'] . ' ' . $row['lname']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['specialty']) ?></td>
        <td>
          <form method="post" action="doctor_action.php" onsubmit="event.preventDefault(); confirmAction('Disable this doctor?', this);">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="action" value="disable">
            <button class="disable">Disable</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>

    <!-- Disabled -->
    <h2>Disabled Doctors</h2>
    <table>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Specialization</th>
        <th>Actions</th>
      </tr>
      <?php while ($row = $disabledDoctors->fetch_assoc()): ?>
      <tr>
        <td>Dr. <?= htmlspecialchars($row['fname'] . ' ' . $row['lname']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['specialty']) ?></td>
        <td>
          <form method="post" action="doctor_action.php" onsubmit="event.preventDefault(); confirmAction('Enable this doctor?', this);">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="action" value="enable">
            <button class="enable">Enable</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>

  </div>

</body>
</html>
