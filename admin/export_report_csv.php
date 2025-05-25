<?php
session_start();
include '../database/db_connect.php';

// Only admin access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php");
  exit();
}

// Set headers to force CSV download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=pharma_report.csv');

$output = fopen('php://output', 'w');

// Output headers
fputcsv($output, ['Appointment ID', 'User ID', 'Doctor ID', 'Date', 'Time', 'Status']);

// Fetch data from appointments table
$result = $conn->query("SELECT * FROM appointments ORDER BY appointment_date DESC, appointment_time DESC");

while ($row = $result->fetch_assoc()) {
  fputcsv($output, [
    $row['appointment_id'],
    $row['user_id'],
    $row['doctor_id'],
    $row['appointment_date'],
    $row['appointment_time'],
    $row['status']
  ]);
}

fclose($output);
exit();
?>
