<?php
session_start();
include '../database/db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php");
  exit();
}

// Fetch counts from database
$totalUsers = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'user'")->fetch_assoc()['count'];
$totalDoctors = $conn->query("SELECT COUNT(*) as count FROM doctors")->fetch_assoc()['count'];
$totalAppointments = $conn->query("SELECT COUNT(*) as count FROM appointments")->fetch_assoc()['count'];
$totalPrescriptions = $conn->query("SELECT COUNT(*) as count FROM prescriptions")->fetch_assoc()['count'];
$totalProducts = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - PharmaCare</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6f8;
    }
    header {
      background-color: #004d40;
      color: white;
      display: flex;
      justify-content: space-between;
      padding: 15px 30px;
      align-items: center;
    }
    .logo {
      font-size: 20px;
      font-weight: bold;
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
      padding: 40px;
      max-width: 1100px;
      margin: auto;
    }
    h2 {
      text-align: center;
      color: #004d40;
      margin-bottom: 40px;
    }
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 30px;
    }
    .card {
      background: white;
      padding: 30px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    .card h3 {
      color: #004d40;
      margin-bottom: 10px;
    }
    .card p {
      font-size: 28px;
      font-weight: bold;
      color: #333;
    }
    footer {
      background-color: #004d40;
      color: white;
      text-align: center;
      padding: 15px;
      position: fixed;
      bottom: 0;
      width: 100%;
      font-size: 14px;
    }
  </style>
</head>
<body>

<header>
  <div class="logo">PharmaCare Admin Panel</div>
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
  <h2>System Overview</h2>
  <div class="cards">
    <div class="card">
      <h3>Total Users</h3>
      <p><?= $totalUsers ?></p>
    </div>
    <div class="card">
      <h3>Total Doctors</h3>
      <p><?= $totalDoctors ?></p>
    </div>
    <div class="card">
      <h3>Appointments</h3>
      <p><?= $totalAppointments ?></p>
    </div>
    <div class="card">
      <h3>Prescriptions</h3>
      <p><?= $totalPrescriptions ?></p>
    </div>
    <div class="card">
      <h3>Products</h3>
      <p><?= $totalProducts ?></p>
    </div>
  </div>
</main>

<footer>
  &copy; 2025 PharmaCare Admin. All rights reserved.
</footer>

</body>
</html>
