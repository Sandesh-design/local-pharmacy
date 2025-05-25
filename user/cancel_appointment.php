<?php
session_start();
include '../database/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
  header("Location: ../login.php");
  exit();
}

if (isset($_GET['id'])) {
  $appointment_id = $_GET['id'];
  $user_id = $_SESSION['user_id'];

  // Optional: verify this appointment belongs to the logged-in user
  $check = $conn->prepare("SELECT * FROM appointments WHERE appointment_id = ? AND user_id = ?");
  $check->bind_param("ii", $appointment_id, $user_id);
  $check->execute();
  $result = $check->get_result();

  if ($result->num_rows === 1) {
    // Update status to 'cancelled'
    $cancel = $conn->prepare("UPDATE appointments SET status = 'cancelled' WHERE appointment_id = ?");
    $cancel->bind_param("i", $appointment_id);
    $cancel->execute();
  }
}

header("Location: my_appointments.php");
exit();
?>
