<?php
session_start();
$success = "";
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "notice_board");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role']; // admin, staff, viewer
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare insert
    $stmt = $conn->prepare("INSERT INTO users (username, email, role, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $role, $hashedPassword);

    if ($stmt->execute()) {
        $success = "✅ Registration successful!";
    } else {
        $error = "❌ Registration failed: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Notice Board</title>
  <style>
    body {
      background: #EDC9AF; /* Desert Sand */
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .form-box {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 400px;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }

    input, select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    button {
      margin-top: 20px;
      padding: 10px;
      width: 100%;
      background: #28a745;
      color: #fff;
      border: none;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
    }

    .message {
      margin-top: 15px;
      text-align: center;
      color: green;
    }

    .error {
      color: red;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>Register User</h2>

    <?php if ($success): ?>
      <div class="message"><?= $success ?></div>
    <?php elseif ($error): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <label>Username</label>
      <input type="text" name="username" required>

      <label>Email</label>
      <input type="email" name="email" required>

      <label>Role</label>
      <select name="role" required>
        <option value="admin">Admin</option>
        <option value="staff">Staff</option>
        <option value="viewer">Viewer</option>
      </select>

      <label>Password</label>
      <input type="password" name="password" required>

      <button type="submit">Register</button>
    </form>
  </div>
</body>
</html>
