<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include __DIR__ . '/db connect.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT name, email, role FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $name, $email, $role);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Determine where to send the user back
$back_link = ($role === 'admin') ? 'admin_dashboard.php' : 'staff_dashboard.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background-color: #EDC9AF; /* Desert Sand */
      margin: 0;
      padding: 40px 20px;
    }

    .card {
      max-width: 500px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #333;
      font-size: 26px;
      margin-bottom: 25px;
    }

    p {
      font-size: 18px;
      margin: 12px 0;
      color: #444;
    }

    strong {
      color: #222;
    }

    a {
      display: block;
      text-align: center;
      margin-top: 30px;
      text-decoration: none;
      background-color: #004d40;
      color: white;
      padding: 12px 18px;
      border-radius: 6px;
      font-size: 16px;
    }

    a:hover {
      background-color: #00332f;
    }

    @media (max-width: 600px) {
      .card {
        padding: 20px;
      }

      h2 {
        font-size: 22px;
      }

      p {
        font-size: 16px;
      }

      a {
        font-size: 15px;
      }
    }
  </style>
</head>
<body>

  <div class="card">
    <h2>🙍 My Profile</h2>

    <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
    <p><strong>Role:</strong> <?= htmlspecialchars(ucfirst($role)) ?></p>

    <a href="<?= $back_link ?>">⬅ Back to Dashboard</a>
  </div>

</body>
</html>
