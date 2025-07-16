<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Notice Board</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('https://images.unsplash.com/photo-1503264116251-35a269479413?auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
      background-size: cover;
    }

    .overlay {
      background: rgba(0, 0, 0, 0.6); 
      min-height: 100vh;
      display: flex;
    }

    .sidebar {
      width: 260px;
      background-color: rgba(0, 51, 34, 0.95);
      color: white;
      padding: 30px 20px;
      font-size: 18px;
    }

    .sidebar h2 {
      font-size: 26px;
      margin-bottom: 30px;
    }

    .sidebar a {
      display: block;
      color: #ccc;
      margin: 18px 0;
      text-decoration: none;
      padding: 14px;
      border-radius: 6px;
      font-size: 18px;
      transition: all 0.3s ease;
    }

    .sidebar a:hover {
      background-color: #4caf50;
      color: #fff;
    }

    .main {
      flex-grow: 1;
      padding: 50px;
      color: #fff;
      font-size: 18px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 40px;
    }

    .header h1 {
      font-size: 36px;
      color: #ffffff;
    }

    .header strong {
      font-size: 20px;
      color: #a0ffcb;
    }

    .success-message {
      background-color: #d4edda;
      color: #155724;
      padding: 16px;
      border: 1px solid #c3e6cb;
      border-radius: 5px;
      margin-bottom: 25px;
      font-size: 18px;
    }

    .card {
      background: rgba(255, 255, 255, 0.95);
      padding: 35px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
      margin-bottom: 30px;
      color: #222;
      font-size: 18px;
    }

    .card h3 {
      color: #2e7d32;
      font-size: 26px;
      margin-bottom: 20px;
    }

    .notice {
      padding: 14px 0;
      border-bottom: 1px solid #ddd;
    }

    .notice:last-child {
      border-bottom: none;
    }

    .notice-title {
      font-weight: 600;
      font-size: 20px;
      color: #333;
      margin-bottom: 6px;
    }

    .notice-date {
      font-size: 16px;
      color: #666;
    }
  </style>
</head>
<body>

  <div class="overlay">
    <div class="sidebar">
      <h2>📝 Notice Board</h2>
      <a href="admin_dashboard.php">🏠 Dashboard</a>
      <a href="create_user.php">👤 Create User</a>
      <a href="manage_users.php">🧑‍💼 Manage Users</a>
      <a href="manage_categories.php">📂 Manage Categories</a>
      <a href="manage_notices.php">📢 Manage Notices</a>
      <a href="my_profile.php">🙍 My Profile</a>
      <a href="logout.php">🚪 Logout</a>
    </div>

    <div class="main">
      <div class="header">
        <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
        <div>Role: <strong><?= htmlspecialchars($_SESSION['role']) ?></strong></div>
      </div>

      <?php if (isset($_GET['user']) && $_GET['user'] == 'created'): ?>
        <div class="success-message">
          ✅ User created successfully!
        </div>
      <?php endif; ?>

      <div class="card">
        <h3>📌 Recent Notices</h3>

        <div class="notice">
          <div class="notice-title">⚠ Maintenance Notice</div>
          <div class="notice-date">Posted on: 2025-07-08</div>
        </div>

        <div class="notice">
          <div class="notice-title">📅 Class Timetable Updated</div>
          <div class="notice-date">Posted on: 2025-07-07</div>
        </div>

        <div class="notice">
          <div class="notice-title">📢 New Event This Friday</div>
          <div class="notice-date">Posted on: 2025-07-05</div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
