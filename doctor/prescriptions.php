<?php
session_start();
include '../database/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
  header("Location: ../login.php");
  exit();
}

$doctor_id = $_SESSION['user_id'];

// Fetch prescriptions assigned to this doctor
$stmt = $conn->prepare("SELECT p.*, u.name as patient_name FROM prescriptions p JOIN users u ON p.user_id = u.user_id WHERE p.doctor_id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Doctor Prescriptions - PharmaCare</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
        Doctor Panel - Prescriptions
      </span>
    </div>
    <nav class="flex space-x-10 text-base font-semibold">
      <a href="dashboard.php" class="hover:text-[#a7c7c1] transition-colors duration-300">Dashboard</a>
      <a href="appointments.php" class="hover:text-[#a7c7c1] transition-colors duration-300">Appointments</a>
      <a href="prescriptions.php" class="hover:text-[#a7c7c1] transition-colors duration-300">Prescriptions</a>
      <a href="../logout.php" class="hover:text-[#a7c7c1] transition-colors duration-300">Logout</a>
    </nav>
  </header>

  <!-- Main Content -->
  <main class="flex-grow w-full max-w-6xl mx-auto py-16 px-6">
    <h2 class="text-4xl font-bold text-[#264653] text-center mb-10">My Prescriptions</h2>

    <div class="overflow-x-auto shadow-xl rounded-2xl bg-white">
      <table class="min-w-full text-sm text-center">
        <thead class="bg-[#2a9d8f] text-white text-md">
          <tr>
            <th class="px-6 py-4">ID</th>
            <th class="px-6 py-4">Patient</th>
            <th class="px-6 py-4">File</th>
            <th class="px-6 py-4">Status</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr class="border-b hover:bg-gray-100 transition-all">
                <td class="px-6 py-4"><?= $row['prescription_id'] ?></td>
                <td class="px-6 py-4"><?= htmlspecialchars($row['patient_name']) ?></td>
                <td class="px-6 py-4">
                  <a href="../uploads/<?= $row['file_name'] ?>" class="text-blue-600 font-semibold underline" target="_blank">View</a>
                </td>
                <td class="px-6 py-4 font-semibold">
                  <?php if ($row['status'] === 'attended'): ?>
                    <span class="text-green-600">Reviewed</span>
                  <?php else: ?>
                    <a href="mark_attended.php?id=<?= $row['prescription_id'] ?>" class="text-blue-500 hover:underline">Mark as Reviewed</a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="4" class="px-6 py-6 text-center text-gray-500">No prescriptions found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-gradient-to-r from-[#2a9d8f] to-[#264653] text-white text-center text-sm py-5 mt-16 shadow-inner">
    © 2025 PharmaCare Doctor Panel. All rights reserved.
  </footer>

</body>
</html>
