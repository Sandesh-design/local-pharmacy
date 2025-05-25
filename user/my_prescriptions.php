<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>My Prescriptions - PharmaCare</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fefcf8;
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
      max-width: 900px;
      margin: 0 auto;
    }

    h2 {
      text-align: center;
      color: #2e7d32;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #e0f2f1;
      color: #2e7d32;
    }

    tr:hover {
      background-color: #f4f6f6;
    }

    footer {
      background-color: #2e7d32;
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
  <div class="logo">
    <img src="../assets/images/pharmacare-logo.png" alt="PharmaCare Logo">
    <span>PharmaCare</span>
  </div>
  <nav>
    <a href="../index.php">Home</a>
    <a href="../products.php">Products</a>
    <a href="../contact.php">Contact</a>
    <a href="../cart.php">Cart</a>
    <a href="upload_prescription.php">Upload Prescription</a>
    <a href="my_prescriptions.php">My Prescriptions</a>
    <a href="book_appointment.php">Book Appointment</a>
    <a href="my_appointments.php">My Appointments</a>
    <a href="../logout.php">Logout</a>
  </nav>
</header>

<main>
  <h2>My Prescriptions</h2>
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>File</th>
        <th>Uploaded Date</th>
        <th>View</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include '../database/db_connect.php';
      $user_id = $_SESSION['user_id'];
      $query = $conn->prepare("SELECT * FROM prescriptions WHERE user_id = ?");
      $query->bind_param("i", $user_id);
      $query->execute();
      $result = $query->get_result();
      if ($result->num_rows > 0) {
        $i = 1;
        while ($row = $result->fetch_assoc()) {
          echo "<tr>
                  <td>{$i}</td>
                  <td>" . htmlspecialchars($row['file_name']) . "</td>
                  <td>" . htmlspecialchars($row['uploaded_at']) . "</td>
                  <td><a href='../uploads/{$row['file_name']}' target='_blank'>View</a></td>
                </tr>";
          $i++;
        }
      } else {
        echo "<tr><td colspan='4'>No prescriptions uploaded yet.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</main>

<footer>
  &copy; 2025 PharmaCare. All rights reserved.
</footer>

</body>
</html>
