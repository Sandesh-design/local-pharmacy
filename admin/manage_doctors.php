<?php
session_start();
include '../database/db_connect.php';

// Only allow access if admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php");
  exit();
}

// Handle doctor deletion
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM doctors WHERE doctor_id = $id");
  header("Location: manage_doctors.php");
  exit();
}

// Handle doctor addition
if (isset($_POST['add_doctor'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $specialization = $_POST['specialization'];
  $password = md5($_POST['password']); // Optional: switch to password_hash()

  $stmt = $conn->prepare("INSERT INTO doctors (name, email, specialization, password) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $email, $specialization, $password);
  $stmt->execute();
  header("Location: manage_doctors.php");
  exit();
}

// Fetch all doctors
$doctors = $conn->query("SELECT * FROM doctors ORDER BY doctor_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Doctors - PharmaCare Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6f8;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
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
      flex: 1;
      max-width: 1000px;
      margin: 40px auto;
      padding: 20px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    h2 {
      text-align: center;
      color: #004d40;
      margin-bottom: 30px;
    }

    .add-form {
      margin-bottom: 30px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
    }

    .add-form input {
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .add-form input[type="submit"] {
      background-color: #004d40;
      color: white;
      font-weight: bold;
      border: none;
      cursor: pointer;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: center;
    }

    th {
      background-color: #e0f2f1;
      color: #004d40;
    }

    .actions a {
      margin: 0 5px;
      color: #004d40;
      text-decoration: none;
      font-weight: bold;
    }

    .actions a:hover {
      text-decoration: underline;
    }

    footer {
      background-color: #004d40;
      color: white;
      text-align: center;
      padding: 15px;
      font-size: 14px;
      margin-top: auto;
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
  <h2>Manage Doctors</h2>

  <!-- Add Doctor Form -->
  <form class="add-form" method="POST">
    <input type="text" name="name" placeholder="Doctor Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="specialization" placeholder="Specialization" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" name="add_doctor" value="Add Doctor">
  </form>

  <!-- Doctor Table -->
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Specialization</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $doctors->fetch_assoc()): ?>
        <tr>
          <td><?= $row['doctor_id'] ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['specialization']) ?></td>
          <td class="actions">
            <a href="manage_doctors.php?delete=<?= $row['doctor_id'] ?>" onclick="return confirm('Delete this doctor?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</main>

<footer>
  &copy; 2025 PharmaCare Admin. All rights reserved.
</footer>

</body>
</html>
