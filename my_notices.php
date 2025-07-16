<?php
session_start();

// Check if user is logged in and is staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}

include("db connect.php");

$user_id = $_SESSION['user_id'];

// Fetch notices created by this user
$sql = "SELECT n.id, n.title, n.status, n.created_at, c.name AS category 
        FROM notices n
        LEFT JOIN categories c ON n.category_id = c.id
        WHERE n.author_id = ?
        ORDER BY n.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Notices</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background: linear-gradient(135deg, #f8f9fa, #ffe0b2);
      margin: 0;
      padding: 40px;
    }

    .container {
      max-width: 960px;
      margin: auto;
      background: #fff;
      padding: 35px;
      border-radius: 14px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      font-size: 28px;
      margin-bottom: 30px;
      color: #004d40;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      font-size: 16px;
    }

    th, td {
      padding: 14px 16px;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #004d40;
      color: #fff;
      font-size: 17px;
      text-align: left;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    .back-link {
      display: block;
      margin-top: 30px;
      text-align: center;
      text-decoration: none;
      font-size: 16px;
      color: #004d40;
      font-weight: 500;
    }

    .back-link:hover {
      text-decoration: underline;
    }

    p {
      text-align: center;
      font-size: 17px;
      color: #777;
    }

    @media (max-width: 768px) {
      body {
        padding: 20px;
      }

      .container {
        padding: 20px;
      }

      table, th, td {
        font-size: 15px;
      }

      h2 {
        font-size: 24px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <h2>📂 My Notices</h2>

  <?php if ($result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Status</th>
          <th>Category</th>
          <th>Date Created</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars(ucfirst($row['status'])) ?></td>
            <td><?= htmlspecialchars($row['category']) ?: '-' ?></td>
            <td><?= htmlspecialchars(date("F j, Y, g:i A", strtotime($row['created_at']))) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No notices found.</p>
  <?php endif; ?>

  <a class="back-link" href="staff_dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
