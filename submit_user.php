<?php
session_start();

// Check if the logged-in user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

// Include database connection
include __DIR__ . '/db connect.php';

// Make sure the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get submitted form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    // Validate
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        die("All fields are required.");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hashedPassword, $role);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect back to dashboard with success message
        header("Location: admin_dashboard.php?user=created");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // If form not submitted via POST
    die("Invalid request.");
}
