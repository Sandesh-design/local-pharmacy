<?php
session_start();
include '../database/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
  header("Location: ../login.php");
  exit();
}

$doctor_id = $_SESSION['user_id'];

// JOIN users to get patient name
$stmt = $conn->prepare("
  SELECT a.appointment_id, u.name AS patient_name, a.appointment_date, a.appointment_time, a.status
  FROM appointments a
  JOIN users u ON a.user_id = u.user_id
  WHERE a.doctor_id = ?
  ORDER BY a.appointment_date DESC
");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Appointments - PharmaCare</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-[#fef9f0] to-[#dbe9e4] min-h-screen flex flex-col font-sans">

  <!-- HEADER -->
  <header class="bg-gradient-to-r from-[#2a9d8f] to-[#264653] text-white flex justify-between items-center px-8 py-5 shadow-md sticky top-0 z-50">
    <div class="flex items-center space-x-4">
      <img src="https://storage.googleapis.com/a1aa/image/5d4130d9-91eb-46ff-80f6-f068c54174df.jpg" alt="PharmaCare logo" class="w-12 h-12 rounded-lg shadow" />
      <span class="font-extrabold text-2xl tracking-wide">Doctor Panel - Appointments</span>
    </div>
    <nav class="flex space-x-10 text-sm font-semibold">
      <a href="dashboard.php" class="hover:text-[#a7c7c1]">Dashboard</a>
      <a href="appointments.php" class="hover:text-[#a7c7c1]">Appointments</a>
      <a href="prescriptions.php" class="hover:text-[#a7c7c1]">Prescriptions</a>
      <a href="../logout.php" class="hover:text-[#a7c7c1]">Logout</a>
    </nav>
  </header>

  <!-- MAIN CONTENT -->
  <main class="flex-grow px-6 pt-10 pb-24 max-w-7xl mx-auto w-full">
    <h1 class="text-4xl text-[#264653] font-extrabold mb-10 text-center">My Appointments</h1>

    <div class="overflow-x-auto bg-white rounded-xl shadow-xl p-6">
      <table class="min-w-full table-auto border-collapse text-center text-base">
        <thead class="bg-[#2a9d8f] text-white">
          <tr>
            <th class="px-6 py-4">ID</th>
            <th class="px-6 py-4">Patient Name</th>
            <th class="px-6 py-4">Date</th>
            <th class="px-6 py-4">Time</th>
            <th class="px-6 py-4">Status</th>
            <th class="px-6 py-4">Update</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr class="border-b border-gray-200 hover:bg-gray-50">
                <td class="px-6 py-4"><?= $row['appointment_id'] ?></td>
                <td class="px-6 py-4"><?= htmlspecialchars($row['patient_name']) ?></td>
                <td class="px-6 py-4"><?= $row['appointment_date'] ?></td>
                <td class="px-6 py-4"><?= $row['appointment_time'] ?></td>
                <td class="px-6 py-4 font-semibold"><?= ucfirst($row['status']) ?></td>
                <td class="px-6 py-4">
                  <form method="POST" action="mark_status.php" class="flex items-center justify-center gap-4">
                    <input type="hidden" name="appointment_id" value="<?= $row['appointment_id'] ?>">
                    <label class="flex items-center space-x-1">
                      <input type="radio" name="status" value="attended" required class="accent-green-600">
                      <span>Attended</span>
                    </label>
                    <label class="flex items-center space-x-1">
                      <input type="radio" name="status" value="not attended" required class="accent-red-600">
                      <span>Not Attended</span>
                    </label>
                    <button type="submit" class="ml-4 px-4 py-2 bg-[#2a9d8f] text-white rounded-md font-semibold hover:bg-[#21867a]">Update</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="6" class="py-8 text-gray-500">No appointments found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="bg-gradient-to-r from-[#2a9d8f] to-[#264653] text-white text-center text-sm py-4 mt-auto shadow-inner">
    © 2025 PharmaCare Doctor Panel. All rights reserved.
  </footer>
</body>
</html>
