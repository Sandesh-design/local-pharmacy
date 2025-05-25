<?php
session_start();
include '../database/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
  header("Location: ../login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT appointment_id, appointment_date, appointment_time, status FROM appointments WHERE user_id = ? ORDER BY appointment_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>My Appointments - PharmaCare</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #fdf9f3; /* updated beige background */
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    header {
      background-color: #2e7d32;
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    nav a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      font-weight: 600;
    }

    nav a:hover {
      text-decoration: underline;
    }

    main {
      flex: 1;
      max-width: 900px;
      margin: 40px auto;
      padding: 20px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    h2 {
      color: #2e7d32;
      text-align: center;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #eee;
      text-align: center;
    }

    th {
      background-color: #e8f5e9;
      color: #2e7d32;
    }

    a.cancel-link {
      color: red;
      font-weight: bold;
      text-decoration: none;
    }

    a.cancel-link:hover {
      text-decoration: underline;
    }

    footer {
      background-color: #2e7d32;
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
  <div class="logo" style="display: flex; align-items: center;">
    <img src="../assets/images/pharmacare-logo.png" alt="PharmaCare Logo" style="height: 30px; margin-right: 10px;">
    <strong>PharmaCare</strong>
  </div>
  <nav>
    <a href="../index.php">Home</a>
    <a href="book_appointment.php">Book</a>
    <a href="my_appointments.php">My Appointments</a>
    <a href="upload_prescription.php">Upload Prescription</a>
    <a href="../logout.php">Logout</a>
  </nav>
</header>

<main>
  <h2>My Appointments</h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['appointment_id'] ?></td>
            <td><?= date("d M Y", strtotime($row['appointment_date'])) ?></td>
            <td><?= date("h:i A", strtotime($row['appointment_time'])) ?></td>
            <td><?= ucfirst($row['status']) ?></td>
            <td>
              <?php if (strtolower($row['status']) === 'pending'): ?>
                <a href="cancel_appointment.php?id=<?= $row['appointment_id'] ?>"
                   class="cancel-link"
                   onclick="return confirm('Are you sure you want to cancel this appointment?')">
                   Cancel
                </a>
              <?php else: ?>
                —
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5">No appointments booked yet.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</main>

<footer>
  &copy; 2025 PharmaCare. All rights reserved.
</footer>

</body>
</html>
