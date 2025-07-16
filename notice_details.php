<?php
session_start();
include("db connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT title, content, created_at FROM notices WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Notice not found.";
    exit();
}

$notice = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($notice['title']) ?> - Notice Details</title>
  <style>
    body {
      font-family: sans-serif;
      padding: 40px;
      background: #f9f9f9;
    }
    .container {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    h1 {
      color: #333;
      margin-bottom: 10px;
    }
    .date {
      color: #777;
      font-size: 14px;
      margin-bottom: 20px;
    }
    .content {
      font-size: 16px;
      line-height: 1.6;
    }
    .back-btn {
      display: inline-block;
      margin-top: 30px;
      background: #607d8b;
      color: white;
      padding: 10px 15px;
      text-decoration: none;
      border-radius: 6px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1><?= htmlspecialchars($notice['title']) ?></h1>
    <div class="date">Posted on: <?= date("F j, Y", strtotime($notice['created_at'])) ?></div>
    <div class="content"><?= nl2br(htmlspecialchars($notice['content'])) ?></div>
    <a class="back-btn" href="view_notices.php">⬅ Back to Notices</a>
  </div>
</body>
</html>
