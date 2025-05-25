<?php
session_start();
include '../database/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
  header("Location: ../login.php");
  exit();
}

$doctor_id = $_SESSION['user_id'];
$success = "";

// Fetch profile
$stmt = $conn->prepare("SELECT name, email, specialization FROM doctors WHERE doctor_id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $specialization = $_POST['specialization'];

  $update = $conn->prepare("UPDATE doctors SET name = ?, email = ?, specialization = ? WHERE doctor_id = ?");
  $update->bind_param("sssi", $name, $email, $specialization, $doctor_id);

  if ($update->execute()) {
    $_SESSION['name'] = $name;
    $success = "Profile updated successfully.";
    $doctor['name'] = $name;
    $doctor['email'] = $email;
    $doctor['specialization'] = $specialization;
  } else {
    $success = "Failed to update profile. Try again.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Profile - PharmaCare Doctor</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-[#fef9f0] to-[#dbe9e4] min-h-screen flex flex-col font-sans">

<!-- Header -->
<header class="bg-gradient-to-r from-[#2a9d8f] to-[#264653] text-white flex justify-between items-center px-8 py-5 shadow-lg">
  <div class="flex items-center space-x-4">
    <img src="https://storage.googleapis.com/a1aa/image/5d4130d9-91eb-46ff-80f6-f068c54174df.jpg" alt="Logo" class="w-12 h-12 rounded-lg shadow-md">
    <span class="font-extrabold text-xl sm:text-3xl tracking-wide drop-shadow-md">Doctor Profile - PharmaCare</span>
  </div>
  <nav class="flex space-x-10 text-base font-semibold">
    <a href="dashboard.php" class="hover:text-[#a7c7c1]">Dashboard</a>
    <a href="appointments.php" class="hover:text-[#a7c7c1]">Appointments</a>
    <a href="prescriptions.php" class="hover:text-[#a7c7c1]">Prescriptions</a>
    <a href="../logout.php" class="hover:text-[#a7c7c1]">Logout</a>
  </nav>
</header>

<!-- Main Content -->
<main class="flex-grow w-full max-w-2xl mx-auto py-16 px-6">
  <h2 class="text-4xl font-bold text-[#264653] text-center mb-10">Edit Your Profile</h2>

  <?php if (!empty($success)): ?>
    <div class="mb-6 text-center font-semibold text-green-700"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form method="POST" class="bg-white rounded-xl shadow-lg border-4 border-[#2a9d8f] p-8 space-y-6">
    <div>
      <label class="block font-semibold text-[#264653] mb-2">Full Name</label>
      <input type="text" name="name" value="<?= htmlspecialchars($doctor['name']) ?>" required
             class="w-full px-4 py-2 border border-gray-300 rounded focus:ring focus:ring-[#2a9d8f]" />
    </div>

    <div>
      <label class="block font-semibold text-[#264653] mb-2">Email Address</label>
      <input type="email" name="email" value="<?= htmlspecialchars($doctor['email']) ?>" required
             class="w-full px-4 py-2 border border-gray-300 rounded focus:ring focus:ring-[#2a9d8f]" />
    </div>

    <div>
      <label class="block font-semibold text-[#264653] mb-2">Specialization</label>
      <input type="text" name="specialization" value="<?= htmlspecialchars($doctor['specialization']) ?>" required
             class="w-full px-4 py-2 border border-gray-300 rounded focus:ring focus:ring-[#2a9d8f]" />
    </div>

    <button type="submit"
            class="bg-[#2a9d8f] hover:bg-[#1f776f] text-white font-bold px-6 py-3 rounded-lg transition duration-300 w-full">
      Update Profile
    </button>
  </form>
</main>

<!-- Footer -->
<footer class="bg-gradient-to-r from-[#2a9d8f] to-[#264653] text-white text-center text-sm py-5 mt-16 shadow-inner">
  &copy; 2025 PharmaCare Doctor Panel. All rights reserved.
</footer>

</body>
</html>
