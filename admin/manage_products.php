<?php
session_start();
include '../database/db_connect.php';

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php");
  exit();
}

// Handle delete
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $conn->query("DELETE FROM products WHERE product_id = $id");
  header("Location: manage_products.php");
  exit();
}

// Handle add
if (isset($_POST['add_product'])) {
  $name = $_POST['name'];
  $desc = $_POST['description'];
  $price = $_POST['price'];

  $stmt = $conn->prepare("INSERT INTO products (name, description, price) VALUES (?, ?, ?)");
  $stmt->bind_param("ssd", $name, $desc, $price);
  $stmt->execute();
  header("Location: manage_products.php");
  exit();
}

// Handle search
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM products";
if (!empty($search)) {
  $sql .= " WHERE name LIKE '%$search%'";
}
$sql .= " ORDER BY product_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Products - Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
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
      margin-bottom: 20px;
    }

    .form-inline, .search-bar {
      display: flex;
      gap: 10px;
      margin-bottom: 25px;
      flex-wrap: wrap;
    }

    .form-inline input, .search-bar input {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      flex: 1;
    }

    .form-inline input[type="submit"], .search-bar button {
      background-color: #004d40;
      color: white;
      border: none;
      cursor: pointer;
      font-weight: bold;
      padding: 10px 15px;
      border-radius: 6px;
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
      text-decoration: none;
      color: #004d40;
      font-weight: bold;
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
  <h2>Manage Products</h2>

  <!-- Add Product Form -->
  <form class="form-inline" method="POST">
    <input type="text" name="name" placeholder="Product Name" required>
    <input type="text" name="description" placeholder="Description" required>
    <input type="number" step="0.01" name="price" placeholder="Price ($)" required>
    <input type="submit" name="add_product" value="Add Product">
  </form>

  <!-- Search Form -->
  <form class="search-bar" method="GET">
    <input type="text" name="search" placeholder="Search by name" value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Search</button>
  </form>

  <!-- Product Table -->
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price ($)</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['product_id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= number_format($row['price'], 2) ?></td>
            <td class="actions">
              <a href="edit_product.php?id=<?= $row['product_id'] ?>">Edit</a> |
              <a href="manage_products.php?delete=<?= $row['product_id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5">No products found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</main>

<footer>
  &copy; 2025 PharmaCare Admin. All rights reserved.
</footer>

</body>
</html>
