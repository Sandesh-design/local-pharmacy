<?php
session_start();
include '../database/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
  header("Location: ../login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

// Validate form input
if (
  empty($_POST['doctor_id']) ||
  empty($_POST['appointment_date']) ||
  empty($_POST['appointment_time'])
) {
  echo "<script>alert('All fields are required.'); window.location.href='book_appointment.php';</script>";
  exit();
}

$doctor_id = $_POST['doctor_id'];
$appointment_date = $_POST['appointment_date'];
$appointment_time = $_POST['appointment_time'];

// Insert appointment into the database
$stmt = $conn->prepare("INSERT INTO appointments (user_id, doctor_id, appointment_date, appointment_time, status) VALUES (?, ?, ?, ?, 'pending')");
$stmt->bind_param("iiss", $user_id, $doctor_id, $appointment_date, $appointment_time);

if ($stmt->execute()) {
  echo "<script>alert('Appointment booked successfully!'); window.location.href='my_appointments.php';</script>";
} else {
  echo "<script>alert('Error booking appointment. Please try again.'); window.location.href='book_appointment.php';</script>";
}
?>
