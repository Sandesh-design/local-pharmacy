<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pharma_care");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

// First, check in the users table
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password']) || md5($password) === $user['password']) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];

        if ($user['role'] === 'admin') {
            header("Location: admin/dashboard.php");
        } elseif ($user['role'] === 'user') {
            header("Location: user/dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        echo "<script>alert('Invalid password.'); window.location.href='login.php';</script>";
        exit();
    }
}

// Now check in the doctors table if not found in users
$stmt2 = $conn->prepare("SELECT * FROM doctors WHERE email = ?");
$stmt2->bind_param("s", $email);
$stmt2->execute();
$result2 = $stmt2->get_result();

if ($result2->num_rows === 1) {
    $doc = $result2->fetch_assoc();

    if (password_verify($password, $doc['password']) || md5($password) === $doc['password']) {
        $_SESSION['user_id'] = $doc['doctor_id'];
        $_SESSION['email'] = $doc['email'];
        $_SESSION['role'] = 'doctor';
        $_SESSION['name'] = $doc['name'];

        header("Location: doctor/dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid password.'); window.location.href='login.php';</script>";
        exit();
    }
}

// If no match found in both tables
echo "<script>alert('No account found with that email.'); window.location.href='login.php';</script>";
?>
