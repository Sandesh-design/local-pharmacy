<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>PharmaCare - Home</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    html, body {
      margin: 0;
      height: 100%;
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6f8;
      color: #333;
    }

    .wrapper {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    header {
      background-color: #2e7d32;
      padding: 15px 40px;
    }

    .header-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo-title {
      display: flex;
      align-items: center;
    }

    .logo-title img {
      height: 40px;
      margin-right: 10px;
      border-radius: 6px;
    }

    .logo-title span {
      font-size: 22px;
      color: white;
      font-weight: 600;
    }

    nav a {
      margin-left: 20px;
      color: white;
      text-decoration: none;
      font-weight: 600;
      font-size: 15px;
    }

    nav a:hover {
      text-decoration: underline;
    }

    main {
      flex: 1;
      padding: 40px 20px;
      background: url('assets/images/pharmacy1.JPG') no-repeat center center;
      background-size: cover;
      position: relative;
      z-index: 1;
    }

    main::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(255, 255, 255, 0.6);
      z-index: -1;
    }

    .hero {
      text-align: center;
      margin-bottom: 50px;
    }

    .hero h1 {
      font-size: 36px;
      color: #2e7d32;
      margin-bottom: 10px;
    }

    .hero p {
      font-size: 18px;
      margin-bottom: 25px;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
    }

    .cta-button {
      background-color: #2e7d32;
      color: white;
      padding: 12px 30px;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      font-size: 16px;
      text-decoration: none;
    }

    .cta-button:hover {
      background-color: #27672a;
    }

    .section {
      max-width: 1100px;
      margin: 0 auto 60px;
      text-align: center;
    }

    .section h2 {
      color: #2e7d32;
      margin-bottom: 20px;
      font-size: 26px;
    }

    .steps {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 25px;
      margin-top: 30px;
    }

    .step-card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .step-card h3 {
      color: #2e7d32;
      margin-bottom: 10px;
    }

    .features {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 25px;
    }

    .feature-box {
      background-color: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .feature-box h3 {
      color: #2e7d32;
      margin-bottom: 10px;
    }

    footer {
      background-color: #2e7d32;
      color: white;
      text-align: center;
      padding: 15px;
      margin-top: auto;
    }
  </style>
</head>
<body>
<div class="wrapper">

  <!-- HEADER -->
  <header>
    <div class="header-container">
      <div class="logo-title">
        <img src="assets/images/pharmacare-logo.png" alt="PharmaCare Logo" />
        <span>PharmaCare</span>
      </div>
      <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="products.php">Products</a>
        <a href="contact.php">Contact</a>
        <a href="cart.php">Cart</a>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
          <a href="user/upload_prescription.php">Upload</a>
          <a href="user/my_prescriptions.php">My Prescriptions</a>
          <a href="user/book_appointment.php">Book</a>
          <a href="user/appointments.php">Appointments</a>
          <a href="logout.php">Logout</a>

        <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'doctor'): ?>
          <a href="doctor/dashboard.php">Dashboard</a>
          <a href="doctor/appointments.php">Appointments</a>
          <a href="doctor/prescriptions.php">Prescriptions</a>
          <a href="logout.php">Logout</a>

        <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
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
    </div>
  </header>

  <!-- MAIN -->
  <main>
    <div class="hero">
      <h1>Welcome to PharmaCare</h1>
      <p>Your trusted online pharmacy. Order certified medicines, consult with licensed doctors, and manage prescriptions—all in one place.</p>
      <a href="products.php" class="cta-button">Browse Medicines</a>
    </div>

    <div class="section">
      <h2>Getting Started</h2>
      <div class="steps">
        <div class="step-card">
          <h3>1. Register</h3>
          <p>Create your account quickly and securely.</p>
        </div>
        <div class="step-card">
          <h3>2. Browse Products</h3>
          <p>Explore our collection of certified medicines.</p>
        </div>
        <div class="step-card">
          <h3>3. Upload Prescription</h3>
          <p>Submit your doctor’s prescription easily.</p>
        </div>
        <div class="step-card">
          <h3>4. Book Appointment</h3>
          <p>Consult with trusted doctors online.</p>
        </div>
      </div>
    </div>

    <div class="section">
      <h2>Why Choose PharmaCare?</h2>
      <div class="features">
        <div class="feature-box">
          <h3>Trusted Medicines</h3>
          <p>We provide authentic products from verified suppliers.</p>
        </div>
        <div class="feature-box">
          <h3>Fast Delivery</h3>
          <p>Receive your orders at your doorstep safely and quickly.</p>
        </div>
        <div class="feature-box">
          <h3>Doctor Support</h3>
          <p>Book appointments and consult online with licensed professionals.</p>
        </div>
        <div class="feature-box">
          <h3>Easy Management</h3>
          <p>Track your prescriptions, orders, and appointments in one place.</p>
        </div>
      </div>
    </div>
  </main>

  <footer>
    &copy; 2025 PharmaCare. All rights reserved.
  </footer>

</div>
</body>
</html>
