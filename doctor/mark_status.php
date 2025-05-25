<?php
session_start();
include '../database/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
  header("Location: ../login.php");
  exit();
}

if (isset($_POST['appointment_id']) && isset($_POST['status'])) {
  $appointment_id = intval($_POST['appointment_id']);
  $status = $_POST['status'];

  $valid = ['attended', 'not attended'];
  if (in_array($status, $valid)) {
    $stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE appointment_id = ?");
    $stmt->bind_param("si", $status, $appointment_id);
    $stmt->execute();
  }
}

header("Location: appointments.php");
exit();
