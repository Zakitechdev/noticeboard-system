<?php
session_start();

// Optional: Only allow access if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit();
}

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "noticeboard");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "❌ A user with this email already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, role, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $username, $email, $password_hash, $role);

        if ($stmt->execute()) {
            $success = "✅ User created successfully!";
        } else {
            $error = "❌ Failed to create user.";
        }
        $stmt->close();
    }

    $check->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add User - Admin</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background: #f4f6f8;
      padding: 50px;
    }

    .container {
      background: #fff;
      width: 400px;
      margin: auto;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 15px;
    }

    input, select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    button {
      width: 100%;
      padding: 10px;
      background: #28a745;
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 6px;
      margin-top: 20px;
      cursor: pointer;
    }

    .message {
      margin-top: 20px;
      text-align: center;
      font-weight: bold;
    }

    .success {
      color: green;
    }

    .error {
      color: red;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Add New User</h2>

    <?php if ($success): ?>
      <div class="message success"><?= $success ?></div>
    <?php elseif ($error): ?>
      <div class="message error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
      <label for="username">Username:</label>
      <input type="text" name="username" required>

      <label for="email">Email:</label>
      <input type="email" name="email" required>

      <label for="password">Password:</label>
      <input type="password" name="password" required>

      <label for="role">Role:</label>
      <select name="role" required>
        <option value="viewer">Viewer</option>
        <option value="staff">Staff</option>
        <option value="admin">Admin</option>
      </select>

      <button type="submit">Create User</button>
    </form>
  </div>

</body>
</html>