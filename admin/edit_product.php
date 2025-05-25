<?php
session_start();
include '../database/db_connect.php';

// Access control: only admins allowed
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php");
  exit();
}

// Get product ID
if (!isset($_GET['id'])) {
  echo "<script>alert('Invalid product.'); window.location.href='manage_products.php';</script>";
  exit();
}

$product_id = $_GET['id'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];

  $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE product_id = ?");
  $stmt->bind_param("ssdi", $name, $description, $price, $product_id);
  $stmt->execute();

  echo "<script>alert('Product updated successfully!'); window.location.href='manage_products.php';</script>";
  exit();
}

// Fetch product data
$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
  echo "<script>alert('Product not found.'); window.location.href='manage_products.php';</script>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Product - PharmaCare Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6f8;
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
      max-width: 600px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    h2 {
      text-align: center;
      color: #004d40;
      margin-bottom: 30px;
    }

    form label {
      display: block;
      margin: 15px 0 5px;
      font-weight: 600;
    }

    form input, form textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }

    form input[type="submit"] {
      margin-top: 20px;
      background-color: #004d40;
      color: white;
      font-weight: bold;
      border: none;
      cursor: pointer;
    }

    form input[type="submit"]:hover {
      background-color: #00695c;
    }

    footer {
      background-color: #004d40;
      color: white;
      text-align: center;
      padding: 15px;
      font-size: 14px;
      margin-top: 50px;
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
  <h2>Edit Product</h2>

  <form method="POST">
    <label for="name">Product Name</label>
    <input type="text" name="name" id="name" value="<?= htmlspecialchars($product['name']) ?>" required>

    <label for="description">Description</label>
    <textarea name="description" id="description" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea>

    <label for="price">Price ($)</label>
    <input type="number" name="price" id="price" value="<?= htmlspecialchars($product['price']) ?>" step="0.01" required>

    <input type="submit" value="Update Product">
  </form>
</main>

<footer>
  &copy; 2025 PharmaCare Admin. All rights reserved.
</footer>

</body>
</html>
