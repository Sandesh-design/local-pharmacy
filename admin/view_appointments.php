<?php
session_start();
include '../database/db_connect.php';

// Access control
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php");
  exit();
}

// Update status if requested
if (isset($_GET['complete'])) {
  $id = $_GET['complete'];
  $conn->query("UPDATE appointments SET status = 'completed' WHERE appointment_id = $id");
  header("Location: view_appointments.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Appointments - Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6f8;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    header {
      background-color: #004d40;
      color: white;
      display: flex;
      justify-content: space-between;
      padding: 15px 30px;
      align-items: center;
    }
    nav a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      font-weight: 600;
    }
    main {
      flex: 1;
      max-width: 1100px;
      margin: 30px auto;
      background: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    h2 {
      text-align: center;
      color: #004d40;
      margin-bottom: 25px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: center;
    }
    th {
      background-color: #e0f2f1;
      color: #004d40;
    }
    .badge {
      padding: 5px 10px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: bold;
      text-transform: capitalize;
    }
    .badge.pending {
      background-color: #ffcc80;
      color: #8d6e63;
    }
    .badge.completed {
      background-color: #a5d6a7;
      color: #2e7d32;
    }
    .actions a {
      margin: 0 6px;
      text-decoration: none;
      font-weight: bold;
      color: #004d40;
    }
    footer {
      background-color: #004d40;
      color: white;
      text-align: center;
      padding: 15px;
      font-size: 14px;
      margin-top: auto;
    }
  </style>
</head>
<body>

<header>
  <div><strong>PharmaCare Admin Panel</strong></div>
  <nav>
  <a href="/pharma-care/admin/dashboard.php">Dashboard</a>
  <a href="/pharma-care/admin/manage_products.php">Products</a>
  <a href="/pharma-care/admin/manage_doctors.php">Doctors</a>
  <a href="/pharma-care/admin/view_appointments.php">Appointments</a>
  <a href="/pharma-care/admin/view_prescriptions.php">Prescriptions</a>
  <a href="/pharma-care/admin/reports.php">Reports</a>
  <a href="/pharma-care/logout.php">Logout</a>
</nav>
</header>

<main>
  <h2>All Appointments</h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>User ID</th>
        <th>Doctor ID</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $appointments = $conn->query("SELECT * FROM appointments ORDER BY appointment_date DESC, appointment_time DESC");
      if ($appointments->num_rows > 0):
        while ($row = $appointments->fetch_assoc()):
      ?>
        <tr>
          <td><?= $row['appointment_id'] ?></td>
          <td><?= $row['user_id'] ?></td>
          <td><?= $row['doctor_id'] ?></td>
          <td><?= date("d M Y", strtotime($row['appointment_date'])) ?></td>
          <td><?= date("h:i A", strtotime($row['appointment_time'])) ?></td>
          <td>
            <span class="badge <?= strtolower($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span>
          </td>
          <td class="actions">
            <?php if ($row['status'] === 'pending'): ?>
              <a href="?complete=<?= $row['appointment_id'] ?>" onclick="return confirm('Mark as completed?')">Mark Completed</a>
            <?php else: ?>
              <em>N/A</em>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; else: ?>
        <tr><td colspan="7">No appointments found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</main>

<footer>
  &copy; 2025 PharmaCare Admin. All rights reserved.
</footer>

</body>
</html>
