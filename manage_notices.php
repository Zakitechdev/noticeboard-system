<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include("db connect.php");

$sql = "SELECT n.id, n.title, n.status, c.name AS category_name, u.name AS author 
        FROM notices n 
        LEFT JOIN categories c ON n.category_id = c.id 
        LEFT JOIN users u ON n.author_id = u.id 
        ORDER BY n.created_at DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Notices</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #EDC9AF; /* Desert Sand */
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            max-width: 1100px;
            margin: auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            color: #004d40;
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #004d40;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn-delete {
            background-color: #e53935;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn-delete:hover {
            background-color: #c62828;
        }

        .back-link {
            margin-top: 20px;
            display: block;
            text-align: center;
            font-weight: bold;
            text-decoration: none;
            color: #004d40;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📋 Manage Notices</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Status</th>
            <th>Category</th>
            <th>Author</th>
            <th>Action</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td><?= htmlspecialchars($row['category_name'] ?? 'Uncategorized') ?></td>
            <td><?= htmlspecialchars($row['author'] ?? 'Unknown') ?></td>
            <td><a class="btn-delete" href="delete_notice.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">🗑 Delete</a></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a class="back-link" href="admin_dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
