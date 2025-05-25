<?php
session_start();
include 'database/db_connect.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $subject = trim($_POST['subject']);
  $message = trim($_POST['message']);

  $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $email, $subject, $message);

  if ($stmt->execute()) {
    $success = "Message sent successfully!";
  } else {
    $error = "Something went wrong. Please try again.";
  }

  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>PharmaCare - Contact</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Poppins', sans-serif;
      background: url('assets/images/contact us.png') no-repeat center center fixed;
      background-size: cover;
      color: #333;
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

    .logo img { height: 30px; margin-right: 10px; }

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
      font-size: 14px;
    }

    nav a:hover {
      text-decoration: underline;
    }

    main {
      flex: 1;
    }

    .container {
      max-width: 700px;
      margin: 50px auto;
      padding: 30px;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0,0,0,0.08);
      backdrop-filter: blur(4px);
    }

    h2 {
      text-align: center;
      color: #2e7d32;
      margin-bottom: 25px;
    }

    form input,
    form textarea {
      width: 100%;
      padding: 12px;
      margin: 10px 0 20px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    form button {
      background-color: #2e7d32;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    form button:hover {
      background-color: #1b5e20;
    }

    footer {
      background-color: #2e7d32;
      color: white;
      text-align: center;
      padding: 15px;
      font-size: 14px;
    }

    .message {
      text-align: center;
      font-weight: bold;
      margin-top: -10px;
      margin-bottom: 20px;
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
      <a href="user/appointments.php">Appointments</a>
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
    <h2>Contact Us</h2>

    <?php if ($success): ?>
      <p class="message" style="color: green;"><?= $success ?></p>
    <?php elseif ($error): ?>
      <p class="message" style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="post">
      <input type="text" name="name" placeholder="Your Full Name" required>
      <input type="email" name="email" placeholder="Your Email Address" required>
      <input type="text" name="subject" placeholder="Subject" required>
      <textarea name="message" placeholder="Your Message..." rows="5" required></textarea>
      <button type="submit">Send Message</button>
    </form>
  </div>
</main>

<footer>
  &copy; 2025 PharmaCare. All rights reserved.
</footer>

</body>
</html>
