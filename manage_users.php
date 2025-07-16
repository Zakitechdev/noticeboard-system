<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

// ✅ Include DB connection
include __DIR__ . '/db connect.php';

// ✅ Query users
$result = mysqli_query($conn, "SELECT id, name, email, role FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: 
                linear-gradient(rgba(237, 201, 175, 0.85), rgba(237, 201, 175, 0.85)),
                url('https://images.unsplash.com/photo-1589729132384-05935c9a1290?auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
            background-size: cover;
            padding: 30px;
            margin: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        table {
            margin: 0 auto;
            width: 80%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 14px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #5D4037;
            color: white;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        a {
            display: inline-block;
            margin-top: 25px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 10px 18px;
            border-radius: 5px;
            margin-left: 10%;
            font-weight: bold;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h2>👥 User List</h2>

    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Role</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['role']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <p><a href="admin_dashboard.php">⬅ Back to Dashboard</a></p>

</body>
</html>
