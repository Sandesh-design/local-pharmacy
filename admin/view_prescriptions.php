<?php
session_start();
include '../database/db_connect.php';

// Access control
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php");
  exit();
}

// Handle delete
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $file = $conn->query("SELECT file_name FROM prescriptions WHERE prescription_id = $id")->fetch_assoc()['file_name'];
  if (file_exists("../uploads/$file")) {
    unlink("../uploads/$file");
  }
  $conn->query("DELETE FROM prescriptions WHERE prescription_id = $id");
  header("Location: view_prescriptions.php");
  exit();
}

// Filters
$search = $_GET['search'] ?? '';
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';

$query = "SELECT * FROM prescriptions WHERE 1";
$params = [];

if ($search) {
  $query .= " AND (file_name LIKE ? OR user_id LIKE ?)";
  $searchParam = "%$search%";
  $params[] = $searchParam;
  $params[] = $searchParam;
}

if ($from && $to) {
  $query .= " AND DATE(uploaded_at) BETWEEN ? AND ?";
  $params[] = $from;
  $params[] = $to;
}

$stmt = $conn->prepare($query);

if ($params) {
  $types = str_repeat("s", count($params));
  $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Prescriptions - Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
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
    nav a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      font-weight: 600;
    }
    main {
      flex: 1;
      max-width: 1100px;
      margin: 30px auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    h2 {
      text-align: center;
      color: #004d40;
    }
    form.filter-bar {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-bottom: 25px;
    }
    form input[type="text"],
    form input[type="date"] {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    form input[type="submit"] {
      padding: 10px 20px;
      background-color: #004d40;
      color: white;
      border: none;
      border-radius: 6px;
      font-weight: bold;
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
      margin: 0 6px;
      text-decoration: none;
      font-weight: bold;
      color: #004d40;
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
  <div><strong>PharmaCare Admin Panel</strong></div>
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
  <h2>View Prescriptions</h2>

  <form class="filter-bar" method="GET">
    <input type="text" name="search" placeholder="Search by filename or user ID" value="<?= htmlspecialchars($search) ?>">
    <input type="date" name="from" value="<?= htmlspecialchars($from) ?>">
    <input type="date" name="to" value="<?= htmlspecialchars($to) ?>">
    <input type="submit" value="Filter">
  </form>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>User ID</th>
        <th>File Name</th>
        <th>Uploaded At</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['prescription_id'] ?></td>
            <td><?= $row['user_id'] ?></td>
            <td><?= htmlspecialchars($row['file_name']) ?></td>
            <td><?= date("d M Y, h:i A", strtotime($row['uploaded_at'])) ?></td>
            <td class="actions">
              <a href="../uploads/<?= $row['file_name'] ?>" download>Download</a>
              <a href="view_prescriptions.php?delete=<?= $row['prescription_id'] ?>" onclick="return confirm('Delete this prescription?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5">No prescriptions found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</main>

<footer>
  &copy; 2025 PharmaCare Admin. All rights reserved.
</footer>

</body>
</html>
