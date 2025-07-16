<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'viewer') {
    header("Location: login.php");
    exit();
}

include("db connect.php");

$sql = "SELECT title, content, created_at FROM notices WHERE status = 'published' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Viewer Dashboard - Notice Board</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --accent: #607d8b;
      --text-dark: #333;
      --overlay: rgba(255, 255, 255, 0.95);
      --desert-sand: #EDC9AF;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: var(--desert-sand) url('https://images.unsplash.com/photo-1576513929822-3bff2c7c6a38?auto=format&fit=crop&w=1650&q=80') no-repeat center center fixed;
      background-size: cover;
      display: flex;
    }

    .sidebar {
      width: 220px;
      height: 100vh;
      background-color: rgba(96, 125, 139, 0.95);
      color: white;
      padding: 30px 20px;
    }

    .sidebar h2 {
      font-size: 22px;
      margin-bottom: 40px;
    }

    .sidebar a {
      display: block;
      margin: 15px 0;
      text-decoration: none;
      color: white;
      font-size: 15px;
      padding: 10px;
      border-radius: 6px;
      transition: background 0.3s ease;
    }

    .sidebar a:hover {
      background-color: #78909c;
    }

    .main {
      flex-grow: 1;
      padding: 40px;
      overflow-y: auto;
      background-color: var(--overlay);
      backdrop-filter: blur(4px);
      box-shadow: inset 0 0 10px rgba(0,0,0,0.1);
      min-height: 100vh;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .header h1 {
      font-size: 26px;
    }

    .header div {
      font-size: 16px;
      color: var(--accent);
    }

    .card {
      background: #ffffff;
      padding: 20px 25px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
      margin-bottom: 20px;
      transition: transform 0.2s ease;
    }

    .card:hover {
      transform: translateY(-3px);
    }

    .notice-title {
      font-size: 18px;
      font-weight: 600;
      color: var(--accent);
      margin-bottom: 5px;
    }

    .notice-date {
      font-size: 13px;
      color: #777;
      margin-bottom: 10px;
    }

    .notice-content {
      font-size: 14px;
      line-height: 1.5;
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <h2><i class="fas fa-eye"></i> Viewer Panel</h2>
    <a href="#"><i class="fas fa-home"></i> Dashboard</a>
    <a href="#"><i class="fas fa-bullhorn"></i> View Notices</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </div>

  <div class="main">
    <div class="header">
      <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>
      <div>Role: <strong><?= htmlspecialchars($_SESSION['role']) ?></strong></div>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="card">
          <div class="notice-title">📢 <?= htmlspecialchars($row['title']) ?></div>
          <div class="notice-date">Posted on: <?= htmlspecialchars($row['created_at']) ?></div>
          <div class="notice-content"><?= nl2br(htmlspecialchars($row['content'])) ?></div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No notices published yet.</p>
    <?php endif; ?>
  </div>

</body>
</html>
