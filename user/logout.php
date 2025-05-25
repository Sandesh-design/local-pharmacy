<?php
session_start();
session_destroy(); // Clear all session data
header("Location: login.php"); // Redirect to login page
exit();
?>
