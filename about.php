<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>About PharmaCare</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: url('assets/images/about.png') no-repeat center center fixed;
      background-size: cover;
      color: #333;
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
      height: 35px;
      margin-right: 10px;
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

    .content {
      max-width: 1000px;
      margin: 60px auto;
      padding: 30px;
      background-color: rgba(255, 255, 255, 0.92);
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(3px);
    }

    .content h1 {
      font-size: 28px;
      color: #2e7d32;
      margin-bottom: 10px;
    }

    .content h2 {
      color: #2e7d32;
      margin-top: 30px;
    }

    .content p {
      font-size: 16px;
      line-height: 1.7;
    }

    .highlight {
      background-color: #e0f2f1;
      border-left: 6px solid #2e7d32;
      padding: 15px 20px;
      margin: 20px 0;
      border-radius: 10px;
    }

    ul {
      padding-left: 20px;
    }

    ul li {
      margin-bottom: 10px;
    }

    footer {
      background-color: #2e7d32;
      color: white;
      text-align: center;
      padding: 15px;
      margin-top: 60px;
    }
  </style>
</head>
<body>

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

<div class="content">
  <h1>About PharmaCare</h1>
  <p>
    PharmaCare is a patient-focused online pharmacy and health services platform founded with the mission to simplify and enhance access to quality healthcare for everyone. We connect patients to trusted doctors and deliver certified medicines directly to their doorstep.
  </p>

  <h2>Our Mission</h2>
  <div class="highlight">
    To empower patients and improve lives by delivering reliable, affordable, and accessible pharmacy and healthcare solutions using technology.
  </div>

  <h2>Our Vision</h2>
  <div class="highlight">
    To become a leading digital healthcare provider known for compassion, quality, and innovation across pharmacy and medical services.
  </div>

  <h2>What Makes Us Different</h2>
  <ul>
    <li>✔ Certified medicines from trusted brands</li>
    <li>✔ Fast, reliable home delivery of medications</li>
    <li>✔ Secure platform to upload and manage prescriptions</li>
    <li>✔ Book appointments with verified healthcare professionals</li>
    <li>✔ Real-time order tracking and customer support</li>
  </ul>
</div>

<footer>
  &copy; 2025 PharmaCare. All rights reserved.
</footer>

</body>
</html>
