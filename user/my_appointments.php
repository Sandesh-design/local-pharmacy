<?php
session_start();
include '../database/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
  header("Location: ../login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

// Fetch appointments
$query = $conn->prepare("SELECT * FROM appointments WHERE user_id = ? ORDER BY appointment_date DESC");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>My Appointments - PharmaCare</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fefcf8;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    header {
      background-color: #2e7d32;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
    }

    .logo {
      display: flex;
      align-items: center;
    }

    .logo img {
      height: 30px;
      margin-right: 10px;
    }

    .logo span {
      font-size: 22px;
      font-weight: 600;
      color: white;
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
      padding: 40px 20px;
      max-width: 900px;
      margin: 0 auto;
    }

    h2 {
      text-align: center;
      color: #2e7d32;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #e0f2f1;
      color: #2e7d32;
    }

    tr:hover {
      background-color: #f4f6f6;
    }

    .cancel-btn {
      color: red;
      font-weight: bold;
      text-decoration: none;
    }

    .cancel-btn:hover {
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
  <div class="logo">
    <img src="../assets/images/pharmacare-logo.png" alt="PharmaCare Logo">
    <span>PharmaCare</span>
  </div>
  <nav>
    <a href="../index.php">Home</a>
    <a href="../products.php">Products</a>
    <a href="../contact.php">Contact</a>
    <a href="../cart.php">Cart</a>
    <a href="upload_prescription.php">Upload Prescription</a>
    <a href="my_prescriptions.php">My Prescriptions</a>
    <a href="book_appointment.php">Book Appointment</a>
    <a href="my_appointments.php">My Appointments</a>
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
            <td><?= date('d M Y', strtotime($row['appointment_date'])) ?></td>
            <td><?= date('h:i A', strtotime($row['appointment_time'])) ?></td>
            <td><?= ucfirst($row['status']) ?></td>
            <td>
              <?php if ($row['status'] === 'pending'): ?>
                <a href="cancel_appointment.php?id=<?= $row['appointment_id'] ?>" class="cancel-btn">Cancel</a>
              <?php else: ?>
                -
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
