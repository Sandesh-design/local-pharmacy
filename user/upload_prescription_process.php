<?php
include '../database/db_connect.php'; // adjust path if needed

session_start();

// For now, we'll use a dummy user ID (replace this with session user ID when login is working)
$user_id = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['prescription_file']) && $_FILES['prescription_file']['error'] === 0) {
        $file = $_FILES['prescription_file'];
        $file_name = basename($file['name']);
        $target_dir = "../assets/uploads/";
        $target_file = $target_dir . time() . "_" . $file_name;

        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'pdf'];

        if (in_array($file_type, $allowed_types)) {
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                // Save to DB
                $stmt = $conn->prepare("INSERT INTO prescriptions (user_id, file_name, uploaded_at) VALUES (?, ?, NOW())");
                $stmt->bind_param("is", $user_id, $target_file);

                if ($stmt->execute()) {
                    echo "<script>alert('Prescription uploaded successfully!'); window.location.href='upload_prescription.php';</script>";
                } else {
                    echo "Database error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Failed to move uploaded file.";
            }
        } else {
            echo "Invalid file type. Only JPG, PNG, or PDF allowed.";
        }
    } else {
        echo "No file uploaded or upload error.";
    }
} else {
    echo "Invalid request.";
}
?>
