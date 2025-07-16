<?php
session_start();

// Only allow staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Staff Dashboard - Notice Board</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --primary: #004d40;
      --primary-dark: #002b26;
      --text-light: #fff;
      --text-dark: #222;
      --card-bg: #ffffff;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      min-height: 100vh;
    }

    .overlay {
      background: rgba(0, 0, 0, 0.6);
      width: 100%;
      display: flex;
    }

    .sidebar {
      width: 260px;
      background: var(--primary-dark);
      color: white;
      padding: 40px 25px;
      display: flex;
      flex-direction: column;
    }

    .sidebar h2 {
      font-size: 26px;
      margin-bottom: 50px;
      color: #fff;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 12px;
      color: #ddd;
      text-decoration: none;
      margin: 16px 0;
      padding: 12px 18px;
      border-radius: 8px;
      transition: background 0.3s ease;
      font-size: 18px;
    }

    .sidebar a:hover {
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
    }

    .main {
      flex-grow: 1;
      padding: 60px 50px;
      color: var(--text-light);
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 40px;
    }

    .header h1 {
      font-size: 36px;
      font-weight: 600;
    }

    .header div {
      font-size: 20px;
    }

    .card {
      background: rgba(255, 255, 255, 0.08);
      padding: 30px;
      border-radius: 14px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.25);
    }

    .card h3 {
      margin-bottom: 25px;
      font-size: 24px;
      color: #fff;
    }

    .notice {
      padding: 18px;
      border-bottom: 1px solid rgba(255,255,255,0.2);
    }

    .notice:last-child {
      border-bottom: none;
    }

    .notice-title {
      font-weight: 600;
      font-size: 18px;
      color: #f1f1f1;
    }

    .notice-date {
      font-size: 15px;
      color: #ccc;
      margin-top: 6px;
    }

    @media (max-width: 768px) {
      .sidebar {
        display: none;
      }

      .main {
        padding: 20px;
      }

      .header h1 {
        font-size: 28px;
      }

      .header div {
        font-size: 16px;
      }

      .card h3 {
        font-size: 20px;
      }

      .notice-title {
        font-size: 16px;
      }

      .notice-date {
        font-size: 13px;
      }
    }
  </style>
</head>
<body>

  <div class="overlay">
    <div class="sidebar">
      <h2><i class="fas fa-user-tie"></i> Staff Panel</h2>
      <a href="staff_dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
      <a href="create_notice.php"><i class="fas fa-plus-circle"></i> Create Notice</a>
      <a href="my_notices.php"><i class="fas fa-folder-open"></i> My Notices</a>
      <a href="my_profile.php"><i class="fas fa-user-circle"></i> Profile</a>
      <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main">
      <div class="header">
        <h1>Welcome, <?= htmlspecialchars($username) ?></h1>
        <div>Role: <strong>Staff</strong></div>
      </div>

      <div class="card">
        <h3>🧾 Your Notices</h3>

        <div class="notice">
          <div class="notice-title">📌 Staff Meeting Tomorrow</div>
          <div class="notice-date">Posted on: 2025-07-06</div>
        </div>
        <div class="notice">
          <div class="notice-title">📋 Assignment Reminder</div>
          <div class="notice-date">Posted on: 2025-07-03</div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
