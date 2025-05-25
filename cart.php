<?php
session_start();
$cart = $_SESSION['cart'] ?? [];

function formatPrice($amount) {
  return '$' . number_format($amount, 2);
}

// Handle quantity update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantities'])) {
  foreach ($_POST['quantities'] as $index => $qty) {
    $qty = max(1, intval($qty));
    if (isset($_SESSION['cart'][$index])) {
      $_SESSION['cart'][$index]['quantity'] = $qty;
    }
  }
  header("Location: cart.php");
  exit();
}

// Handle checkout redirect
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proceed_checkout'])) {
  header("Location: checkout.php");
  exit();
}

// Handle remove
if (isset($_GET['remove'])) {
  $removeId = $_GET['remove'];
  if (isset($_SESSION['cart'][$removeId])) {
    unset($_SESSION['cart'][$removeId]);
    header("Location: cart.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>My Cart - PharmaCare</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background-color: #fdf9f3 !important;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    header {
      background-color: #2e7d32;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .logo {
      display: flex;
      align-items: center;
    }
    .logo img {
      height: 30px;
      margin-right: 10px;
    }
    .logo span {
      font-size: 22px;
      font-weight: 600;
      color: white;
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
      max-width: 1100px;
      margin: 40px auto;
      padding: 20px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    h2 {
      color: #2e7d32;
      text-align: center;
      margin-bottom: 30px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }
    th {
      background-color: #e8f5e9;
      color: #2e7d32;
    }
    .product-img {
      width: 80px;
      height: auto;
      border-radius: 6px;
    }
    .remove-btn {
      background: #c62828;
      color: white;
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }
    .update-btn {
      background-color: #2e7d32;
      color: white;
      font-weight: bold;
      padding: 10px 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 20px;
    }
    .qty-input {
      width: 60px;
      padding: 6px;
      text-align: center;
      font-size: 14px;
    }
    .total-box {
      margin-top: 25px;
      text-align: right;
      font-size: 20px;
      font-weight: bold;
      color: #2e7d32;
    }
    .checkout-btn {
      background-color: #2e7d32;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      margin-top: 15px;
    }
    footer {
      background-color: #2e7d32;
      color: white;
      text-align: center;
      padding: 15px;
      font-size: 14px;
    }
  </style>
</head>
<body>

<header>
  <div class="logo">
    <img src="assets/images/pharmacare-logo.png" alt="PharmaCare Logo" />
    <span>PharmaCare</span>
  </div>
  <nav>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="products.php">Products</a>
    <a href="contact.php">Contact</a>
    <a href="cart.php">Cart</a>
    <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'user'): ?>
      <a href="user/upload_prescription.php">Upload</a>
      <a href="user/my_prescriptions.php">My Prescriptions</a>
      <a href="user/book_appointment.php">Book</a>
      <a href="user/my_appointments.php">Appointments</a>
      <a href="logout.php">Logout</a>
    <?php elseif (isset($_SESSION['user_id']) && $_SESSION['role'] === 'doctor'): ?>
      <a href="doctor/dashboard.php">Dashboard</a>
      <a href="doctor/appointments.php">Appointments</a>
      <a href="doctor/prescriptions.php">Prescriptions</a>
      <a href="logout.php">Logout</a>
    <?php elseif (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
      <a href="admin/dashboard.php">Dashboard</a>
      <a href="admin/manage_products.php">Products</a>
      <a href="admin/manage_doctors.php">Doctors</a>
      <a href="admin/view_appointments.php">Appointments</a>
      <a href="admin/view_prescriptions.php">Prescriptions</a>
      <a href="admin/reports.php">Reports</a>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    <?php endif; ?>
  </nav>
</header>

<main>
  <h2>Your Shopping Cart</h2>

  <form method="POST">
    <table>
      <thead>
        <tr>
          <th>Image</th>
          <th>Product</th>
          <th>Unit Price</th>
          <th>Qty</th>
          <th>Total</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($cart)): ?>
          <?php $grandTotal = 0; ?>
          <?php foreach ($cart as $index => $item): 
            $itemTotal = $item['price'] * $item['quantity'];
            $grandTotal += $itemTotal;
          ?>
            <tr>
              <td><img src="<?= htmlspecialchars($item['image']) ?>" class="product-img" alt=""></td>
              <td><?= htmlspecialchars($item['name']) ?></td>
              <td><?= formatPrice($item['price']) ?></td>
              <td><input type="number" name="quantities[<?= $index ?>]" value="<?= $item['quantity'] ?>" min="1" class="qty-input"></td>
              <td><?= formatPrice($itemTotal) ?></td>
              <td><a href="cart.php?remove=<?= $index ?>" class="remove-btn">Remove</a></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="6">Your cart is empty.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

    <?php if (!empty($cart)): ?>
      <div class="total-box">
        Grand Total: <?= formatPrice($grandTotal) ?>
      </div>
      <div style="text-align: right;">
        <button type="submit" name="update_quantities" class="update-btn">Update Quantities</button>
        <button type="submit" name="proceed_checkout" class="checkout-btn">Proceed to Checkout</button>
      </div>
    <?php endif; ?>
  </form>
</main>

<footer>
  &copy; 2025 PharmaCare. All rights reserved.
</footer>

</body>
</html>
