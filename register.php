<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Register - PharmaCare</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #fdf9f3; /* updated beige background */
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    header {
      background-color: #2e7d32;
      padding: 15px 30px;
      color: white;
      display: flex;
      justify-content: space-between;
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
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px;
    }
    .form-box {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
      width: 100%;
      max-width: 400px;
    }
    h2 {
      text-align: center;
      color: #2e7d32;
      margin-bottom: 25px;
    }
    input, select {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    button {
      width: 100%;
      background-color: #2e7d32;
      color: white;
      font-weight: bold;
      padding: 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover {
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
  <script>
    function toggleSpecialization(select) {
      const specField = document.getElementById('specializationField');
      specField.style.display = select.value === 'doctor' ? 'block' : 'none';
    }
  </script>
</head>
<body>

<header>
  <div><strong>PharmaCare</strong></div>
  <nav>
    <a href="index.php">Home</a>
    <a href="login.php">Login</a>
  </nav>
</header>

<main>
  <div class="form-box">
    <h2>Create an Account</h2>
    <form action="register_process.php" method="POST">
      <input type="text" name="name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="password" name="password" placeholder="Password" required>

      <select name="role" onchange="toggleSpecialization(this)" required>
        <option value="">Select Role</option>
        <option value="user">User</option>
        <option value="doctor">Doctor</option>
        <option value="admin">Admin</option>
      </select>

      <div id="specializationField" style="display:none;">
        <input type="text" name="specialization" placeholder="Specialization (Doctor only)">
      </div>

      <button type="submit">Register</button>
    </form>
  </div>
</main>

<footer>
  &copy; 2025 PharmaCare. All rights reserved.
</footer>

</body>
</html>
