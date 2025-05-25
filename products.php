<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>PharmaCare - Products</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fdf9f3 !important; /* ✅ Beige background */
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    header {
      background-color: #2e7d32;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
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
      padding: 40px 20px;
    }

    .container {
      max-width: 1200px;
      margin: auto;
    }

    h2 {
      text-align: center;
      color: #2e7d32;
      margin-bottom: 30px;
      font-size: 28px;
    }

    .products-row {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: center;
    }

    .product-card {
      background: white;
      width: 300px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.08);
      padding: 20px;
      text-align: center;
      transition: transform 0.2s ease-in-out;
    }

    .product-card:hover {
      transform: translateY(-5px);
    }

    .product-card img {
      width: 100%;
      height: 200px;
      object-fit: contain;
      border-radius: 8px;
    }

    .product-card h3 {
      color: #2e7d32;
      margin-top: 15px;
      font-size: 18px;
    }

    .product-card p {
      color: #333;
      font-weight: bold;
      margin: 10px 0;
    }

    .product-card button {
      background-color: #2e7d32;
      color: white;
      border: none;
      padding: 10px 18px;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
    }

    .product-card button:hover {
      background-color: #1b5e20;
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
    <img src="assets/images/pharmacare-logo.png" alt="PharmaCare Logo">
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
  <div class="container">
    <h2>Our Products</h2>
    <div class="products-row">

      <!-- Product 1 -->
      <div class="product-card">
        <form method="POST" action="add_to_cart.php">
          <input type="hidden" name="product_id" value="1" />
          <input type="hidden" name="product_name" value="Ibuprofen" />
          <input type="hidden" name="price" value="5.00" />
          <input type="hidden" name="image" value="assets/images/ibuprofen.PNG" />
          <img src="assets/images/ibuprofen.PNG" alt="Ibuprofen" />
          <h3>Ibuprofen</h3>
          <p>$5.00</p>
          <button type="submit">Add to Cart</button>
        </form>
      </div>

      <!-- Product 2 -->
      <div class="product-card">
        <form method="POST" action="add_to_cart.php">
          <input type="hidden" name="product_id" value="2" />
          <input type="hidden" name="product_name" value="Paracetamol" />
          <input type="hidden" name="price" value="6.50" />
          <input type="hidden" name="image" value="assets/images/paracetamol.PNG" />
          <img src="assets/images/paracetamol.PNG" alt="Paracetamol" />
          <h3>Paracetamol</h3>
          <p>$6.50</p>
          <button type="submit">Add to Cart</button>
        </form>
      </div>

      <!-- Product 3 -->
      <div class="product-card">
        <form method="POST" action="add_to_cart.php">
          <input type="hidden" name="product_id" value="3" />
          <input type="hidden" name="product_name" value="Vitamin C" />
          <input type="hidden" name="price" value="9.00" />
          <input type="hidden" name="image" value="assets/images/vitamin c.PNG" />
          <img src="assets/images/vitamin c.PNG" alt="Vitamin C" />
          <h3>Vitamin C</h3>
          <p>$9.00</p>
          <button type="submit">Add to Cart</button>
        </form>
      </div>

    </div>
  </div>
</main>

<footer>
  &copy; 2025 PharmaCare. All rights reserved.
</footer>

</body>
</html>
