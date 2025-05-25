<?php
session_start();

// Clear the cart after checkout
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout - PharmaCare</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f6f8;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    header {
      background-color: #2e7d32;
      color: white;
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
    main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 60px 20px;
    }
    .confirmation-box {
      background: white;
      padding: 40px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    .confirmation-box h2 {
      color: #2e7d32;
      margin-bottom: 15px;
    }
    .confirmation-box p {
      font-size: 16px;
      color: #333;
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
</header>

<main>
  <div class="confirmation-box">
    <h2>Thank You!</h2>
    <p>Your order has been successfully placed.</p>
    <p>You will receive a confirmation email shortly.</p>
    <p><a href="products.php">← Continue Shopping</a></p>
  </div>
</main>

<footer>
  &copy; 2025 PharmaCare. All rights reserved.
</footer>

</body>
</html>
