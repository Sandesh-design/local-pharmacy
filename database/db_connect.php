<?php
// db_connect.php

$host = "localhost";
$user = "root";
$password = "";  // default XAMPP password is empty
$database = "pharma_care";

// Create connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// echo "Connected successfully";  // (Optional - for testing)
?>
