<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: /pharma-care/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>User Dashboard - PharmaCare</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #fdf9f3; /* Updated to match site background */
    }

    header {
      background-color: #2e7d32;
      padding: 20px 40px;
      color: white;
      font-size: 26px;
      font-weight: 600;
    }

    .container {
      max-width: 1100px;
      margin: 50px auto;
      padding: 20px;
    }

    .welcome {
      text-align: center;
      margin-bottom: 40px;
    }

    .welcome h2 {
      color: #2e7d32;
      font-size: 28px;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 25px;
    }

    .card {
      background-color: white;
      padding: 30px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      transition: transform 0.2s ease-in-out;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card a {
      text-decoration: none;
      color: #2e7d32;
      font-weight: 600;
      display: block;
      margin-top: 15px;
    }

    .card-icon {
      font-size: 40px;
      margin-bottom: 10px;
    }

    footer {
      background-color: #2e7d32;
      color: white;
      text-align: center;
      padding: 15px;
      margin-top: 50px;
    }
  </style>
</head>
<body>

<header>
  PharmaCare - User Dashboard
</header>

<div class="container">
  <div class="welcome">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?>!</h2>
    <p>Select an action below:</p>
  </div>

  <div class="cards">
    <div class="card">
      <div class="card-icon">📅</div>
      <a href="/pharma-care/book_appointment.php">Book Appointment</a>
    </div>

    <div class="card">
      <div class="card-icon">📄</div>
      <a href="/pharma-care/upload_prescription.php">Upload Prescription</a>
    </div>

    <div class="card">
      <div class="card-icon">🗂</div>
      <a href="/pharma-care/my_prescriptions.php">My Prescriptions</a>
    </div>

    <div class="card">
      <div class="card-icon">🛒</div>
      <a href="/pharma-care/products.php">Browse Medicines</a>
    </div>

    <div class="card">
      <div class="card-icon">🛍</div>
      <a href="/pharma-care/cart.php">My Cart</a>
    </div>

    <div class="card">
      <div class="card-icon">🚪</div>
      <a href="/pharma-care/logout.php">Logout</a>
    </div>
  </div>
</div>

<footer>
  &copy; 2025 PharmaCare. All rights reserved.
</footer>

</body>
</html>
