<?php
session_start();
include '../database/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
  header("Location: ../login.php");
  exit();
}

$doctor_id = $_SESSION['user_id'];

// Fetch doctor profile info
$profileStmt = $conn->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
$profileStmt->bind_param("i", $doctor_id);
$profileStmt->execute();
$profile = $profileStmt->get_result()->fetch_assoc();

// Fetch count of appointments
$app_result = $conn->query("SELECT COUNT(*) AS total FROM appointments WHERE doctor_id = $doctor_id");
$appointments = $app_result->fetch_assoc()['total'] ?? 0;

// Fetch count of prescriptions
$pres_result = $conn->query("SELECT COUNT(*) AS total FROM prescriptions WHERE doctor_id = $doctor_id");
$prescriptions = $pres_result->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Doctor Dashboard - PharmaCare</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-gradient-to-b from-[#fef9f0] to-[#dbe9e4] min-h-screen flex flex-col font-sans">

  <!-- Header -->
  <header class="bg-gradient-to-r from-[#2a9d8f] to-[#264653] text-white flex justify-between items-center px-8 py-5 shadow-lg">
    <div class="flex items-center space-x-4">
      <img
        src="https://storage.googleapis.com/a1aa/image/5d4130d9-91eb-46ff-80f6-f068c54174df.jpg"
        alt="PharmaCare logo"
        class="w-12 h-12 rounded-lg shadow-md"
      />
      <span class="font-extrabold text-xl sm:text-3xl tracking-wide drop-shadow-md">
        Doctor Dashboard - PharmaCare
      </span>
    </div>
    <nav class="flex space-x-10 text-base font-semibold">
      <a href="dashboard.php" class="hover:text-[#a7c7c1] transition-colors duration-300">Dashboard</a>
      <a href="appointments.php" class="hover:text-[#a7c7c1] transition-colors duration-300">Appointments</a>
      <a href="prescriptions.php" class="hover:text-[#a7c7c1] transition-colors duration-300">Prescriptions</a>
      <a href="edit_profile.php" class="hover:text-[#a7c7c1] transition-colors duration-300">Edit Profile</a>
      <a href="../logout.php" class="hover:text-[#a7c7c1] transition-colors duration-300">Logout</a>
    </nav>
  </header>

  <!-- Main Content -->
  <main class="flex-grow flex flex-col items-center pt-20 px-6">
    <h1 class="text-[#264653] font-extrabold text-4xl sm:text-5xl mb-12 drop-shadow-sm">
      Welcome, Dr. <?= htmlspecialchars($_SESSION['name']) ?>
    </h1>

    <!-- Profile Card -->
    <div class="w-full max-w-4xl bg-white rounded-xl border-4 border-[#2a9d8f] shadow-lg p-6 mb-16">
      <h2 class="text-2xl font-bold text-[#264653] mb-4">Your Profile</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <p><strong>Name:</strong> <?= htmlspecialchars($profile['name'] ?? 'N/A') ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($profile['email'] ?? 'N/A') ?></p>
        <p><strong>Specialization:</strong> <?= htmlspecialchars($profile['specialization'] ?? 'Not specified') ?></p>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-20 max-w-4xl w-full mb-12">
      <div class="flex flex-col items-center bg-white rounded-3xl shadow-xl p-12 border-4 border-[#2a9d8f] hover:scale-105 transform transition-transform duration-300">
        <img
          src="https://storage.googleapis.com/a1aa/image/c1523a4a-9da3-4922-c7f6-d609eeb5f8bf.jpg"
          alt="Calendar icon representing appointments"
          class="w-28 h-28 mb-8"
        />
        <p class="text-[#264653] text-2xl font-semibold mb-4 tracking-wide">Your Appointments</p>
        <p class="text-[#2a9d8f] font-extrabold text-7xl"><?= $appointments ?></p>
      </div>
      <div class="flex flex-col items-center bg-white rounded-3xl shadow-xl p-12 border-4 border-[#2a9d8f] hover:scale-105 transform transition-transform duration-300">
        <img
          src="https://storage.googleapis.com/a1aa/image/4d327246-c400-4a0a-e897-56e9ad0ff49f.jpg"
          alt="Medicine icon representing prescriptions"
          class="w-28 h-28 mb-8"
        />
        <p class="text-[#264653] text-2xl font-semibold mb-4 tracking-wide">Your Prescriptions</p>
        <p class="text-[#2a9d8f] font-extrabold text-7xl"><?= $prescriptions ?></p>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-gradient-to-r from-[#2a9d8f] to-[#264653] text-white text-center text-sm py-5 mt-10 shadow-inner">
    © 2025 PharmaCare Doctor Panel. All rights reserved.
  </footer>
</body>
</html>
