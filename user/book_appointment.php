<?php
session_start();
include '../database/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
  header("Location: ../login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Book Appointment - PharmaCare</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #fdf9f3; /* updated to beige/cream */
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
      padding: 40px;
      max-width: 700px;
      margin: 40px auto;
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    h2 {
      text-align: center;
      color: #2e7d32;
      margin-bottom: 30px;
    }
    label {
      font-weight: 600;
      color: #2e7d32;
      display: block;
      margin-bottom: 8px;
    }
    select, input[type="date"], input[type="time"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      background-color: #2e7d32;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
    }
    button:hover {
      background-color: #1b5e20;
    }
    footer {
      background-color: #2e7d32;
      color: white;
      text-align: center;
      padding: 15px;
      font-size: 14px;
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
  <h2>Book an Appointment</h2>
  <form method="POST" action="book_appointment_process.php">
    <label for="doctor_id">Select Doctor</label>
    <select name="doctor_id" required>
      <option value="">-- Choose a Doctor --</option>
      <?php
      $doctors = $conn->query("SELECT doctor_id, name FROM doctors");
      while ($doc = $doctors->fetch_assoc()) {
        echo "<option value='{$doc['doctor_id']}'>" . htmlspecialchars($doc['name']) . "</option>";
      }
      ?>
    </select>

    <label for="appointment_date">Appointment Date</label>
    <input type="date" name="appointment_date" required>

    <label for="appointment_time">Appointment Time</label>
    <input type="time" name="appointment_time" required>

    <button type="submit">Book Appointment</button>
  </form>
</main>

<footer>
  &copy; 2025 PharmaCare. All rights reserved.
</footer>

</body>
</html>
