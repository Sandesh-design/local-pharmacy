<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pharma_care");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];
$specialization = $_POST['specialization'] ?? '';  // for doctor only

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Check if email already exists
$check = $conn->prepare("SELECT * FROM users WHERE email = ? UNION SELECT * FROM doctors WHERE email = ?");
$check->bind_param("ss", $email, $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('Email already exists. Try logging in.'); window.location.href='register.php';</script>";
    exit();
}

if ($role === 'doctor') {
    // Insert into doctors table
    $stmt = $conn->prepare("INSERT INTO doctors (name, email, specialization, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $specialization, $hashedPassword);
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = 'doctor';
        $_SESSION['name'] = $name;
        header("Location: doctor/dashboard.php");
        exit();
    }
} else {
    // Insert into users table
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
        $_SESSION['name'] = $name;

        if ($role === 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: user/dashboard.php");
        }
        exit();
    }
}

echo "<script>alert('Registration failed. Please try again.'); window.location.href='register.php';</script>";
?>
