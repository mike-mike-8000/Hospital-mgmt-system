<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.html");
    exit();
}
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
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Specialization</th>
        <th>Actions</th>
      </tr>
      <tr>
        <td>Dr. John Doe</td>
        <td>john@serenityhospital.com</td>
        <td>Cardiologist</td>
        <td>
          <button>Approve</button>
          <button class="reject">Reject</button>
        </td>
      </tr>
      <tr>
        <td>Dr. Fatima Yusuf</td>
        <td>fatima@serenityhospital.com</td>
        <td>Neurologist</td>
        <td>
          <button>Approve</button>
          <button class="reject">Reject</button>
        </td>
      </tr>
      <tr>
        <td>Dr. Kelvin Mwangi</td>
        <td>kelvin@serenityhospital.com</td>
        <td>Pediatrician</td>
        <td>
          <button>Approve</button>
          <button class="reject">Reject</button>
        </td>
      </tr>
      <tr>
        <td>Dr. Adaeze Obi</td>
        <td>adaeze@serenityhospital.com</td>
        <td>Radiologist</td>
        <td>
          <button>Approve</button>
          <button class="reject">Reject</button>
        </td>
      </tr>
    </table>

    <h2>Approved Doctors</h2>
    <table>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Specialization</th>
        <th>Status</th>
      </tr>
      <tr>
        <td>Dr. Jane Smith</td>
        <td>jane@serenityhospital.com</td>
        <td>Dermatologist</td>
        <td>Approved</td>
      </tr>
      <tr>
        <td>Dr. Marcus Bello</td>
        <td>marcus@serenityhospital.com</td>
        <td>Orthopedic Surgeon</td>
        <td>Approved</td>
      </tr>
      <tr>
        <td>Dr. Linda Choi</td>
        <td>linda@serenityhospital.com</td>
        <td>Ophthalmologist</td>
        <td>Approved</td>
      </tr>
      <tr>
        <td>Dr. Nneka Ume</td>
        <td>nneka@serenityhospital.com</td>
        <td>Oncologist</td>
        <td>Approved</td>
      </tr>
    </table>

  </div>

</body>
</html>
