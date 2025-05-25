<?php
session_start();
include '../database/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php");
  exit();
}

// Total counts
$totalUsers = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role = 'user'")->fetch_assoc()['count'];
$totalDoctors = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role = 'doctor'")->fetch_assoc()['count'];
$totalAppointments = $conn->query("SELECT COUNT(*) AS count FROM appointments")->fetch_assoc()['count'];
$totalPrescriptions = $conn->query("SELECT COUNT(*) AS count FROM prescriptions")->fetch_assoc()['count'];

// Appointment status counts
$statusCounts = ['pending' => 0, 'attended' => 0, 'cancelled' => 0];
$statusResult = $conn->query("SELECT status, COUNT(*) as count FROM appointments GROUP BY status");
while ($row = $statusResult->fetch_assoc()) {
  $statusCounts[$row['status']] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Reports - PharmaCare</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    nav a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      font-weight: bold;
    }

    nav a:hover {
      text-decoration: underline;
    }

    main {
      max-width: 1200px;
      margin: 40px auto;
      padding: 20px;
    }

    h2 {
      color: #004d40;
      text-align: center;
      margin-bottom: 40px;
    }

    .report-row {
      display: flex;
      justify-content: space-between;
      gap: 20px;
      margin-bottom: 40px;
      flex-wrap: wrap;
    }

    .box {
      background: #e0f2f1;
      padding: 20px;
      flex: 1;
      min-width: 200px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .box h3 {
      margin: 0;
      color: #00695c;
      font-size: 18px;
    }

    .box p {
      font-size: 30px;
      font-weight: bold;
      color: #004d40;
    }

    .chart {
      text-align: center;
      padding: 30px 0;
    }

    .export-btn {
      display: block;
      width: fit-content;
      margin: 0 auto 30px auto;
      background: #004d40;
      color: white;
      padding: 12px 25px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      text-decoration: none;
    }

    footer {
      background-color: #004d40;
      color: white;
      text-align: center;
      padding: 15px;
      font-size: 14px;
      margin-top: 60px;
    }
  </style>
</head>
<body>

<header>
  <div><strong>PharmaCare Admin Panel</strong></div>
  <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="manage_products.php">Products</a>
    <a href="manage_doctors.php">Doctors</a>
    <a href="view_appointments.php">Appointments</a>
    <a href="view_prescriptions.php">Prescriptions</a>
    <a href="reports.php">Reports</a>
    <a href="../logout.php">Logout</a>
  </nav>
</header>

<main>
  <h2>System Reports</h2>

  <div class="report-row">
    <div class="box">
      <h3>Total Users</h3>
      <p><?= $totalUsers ?></p>
    </div>
    <div class="box">
      <h3>Total Doctors</h3>
      <p><?= $totalDoctors ?></p>
    </div>
    <div class="box">
      <h3>Appointments</h3>
      <p><?= $totalAppointments ?></p>
    </div>
    <div class="box">
      <h3>Prescriptions</h3>
      <p><?= $totalPrescriptions ?></p>
    </div>
  </div>

  <a href="export_report_csv.php" class="export-btn">Export Report CSV</a>

  <div class="chart">
    <h2>Appointment Status Chart</h2>
    <canvas id="appointmentChart" width="600" height="300"></canvas>
  </div>
</main>

<footer>
  &copy; 2025 PharmaCare Admin. All rights reserved.
</footer>

<script>
  const ctx = document.getElementById('appointmentChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Pending', 'Attended', 'Cancelled'],
      datasets: [{
        label: 'Number of Appointments',
        data: [
          <?= $statusCounts['pending'] ?>,
          <?= $statusCounts['attended'] ?>,
          <?= $statusCounts['cancelled'] ?>
        ],
        backgroundColor: ['#ffca28', '#66bb6a', '#ef5350']
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: { stepSize: 1 }
        }
      }
    }
  });
</script>

</body>
</html>
