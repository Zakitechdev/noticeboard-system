<?php
session_start();
$login_error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $conn = new mysqli("localhost", "root", "", "notice_board");

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
      if (password_verify($password, $user['password'])) {
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['username'] = $user['username'];
          $_SESSION['role'] = $user['role'];

          if ($user['role'] == 'admin') {
              header("Location: admin_dashboard.php");
              exit();
          } elseif ($user['role'] == 'staff') {
              header("Location: staff_dashboard.php");
              exit();
          } elseif ($user['role'] == 'viewer') {
              header("Location: viewer_dashboard.php");
              exit();
          } else {
              $login_error = "Unknown role.";
          }
      } else {
          $login_error = "❌ Incorrect password.";
      }
  } else {
      $login_error = "❌ Email not found.";
  }

  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Notice Board System</title>
  <style>
    body {
      background: linear-gradient(to right, #a1c4fd, #c2e9fb); /* gradient background */
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-box {
      background: #fff;
      padding: 35px;
      border-radius: 15px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      width: 380px;
    }

    .login-box h2 {
      margin-bottom: 25px;
      text-align: center;
      color: #004d40;
      font-size: 24px;
    }

    .login-box label {
      font-weight: bold;
      display: block;
      margin-bottom: 6px;
      margin-top: 18px;
      color: #444;
      font-size: 15px;
    }

    .login-box input {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
    }

    .login-box button {
      width: 100%;
      padding: 12px;
      background: #007BFF;
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      margin-top: 25px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .login-box button:hover {
      background: #0056b3;
    }

    .note {
      text-align: center;
      font-size: 14px;
      margin-top: 18px;
      color: #555;
    }

    .error {
      color: red;
      text-align: center;
      margin-top: 10px;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <div class="login-box">
    <h2>Login</h2>

    <?php if ($login_error): ?>
      <div class="error"><?= $login_error ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" required>

      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>

      <button type="submit">Login</button>
    </form>

    <div class="note">
      Use: <b>zaki@gmail.com</b> / <b>123456</b>
    </div>
  </div>

</body>
</html>
