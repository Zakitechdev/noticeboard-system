<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

include __DIR__ . '/db connect.php';

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_name'])) {
    $name = trim($_POST['category_name']);
    if (!empty($name)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO categories (name) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        header("Location: manage_categories.php?added=1");
        exit();
    }
}

// ✅ Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM categories WHERE id = $id");
    header("Location: manage_categories.php?deleted=1");
    exit();
}

// ✅ Fetch categories ordered by ID (latest first)
$result = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Categories</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #EDC9AF; /* Desert Sand */
            padding: 30px;
            margin: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        form {
            text-align: center;
            margin-bottom: 25px;
        }

        input[type="text"] {
            padding: 8px;
            width: 250px;
            font-size: 14px;
        }

        button {
            padding: 8px 14px;
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #218838;
        }

        table {
            margin: 0 auto;
            width: 70%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
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

        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .message.success {
            color: green;
        }

        .message.deleted {
            color: red;
        }

        a {
            color: #d32f2f;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 10px 16px;
            border-radius: 5px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

        .back-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h2>📂 Manage Categories</h2>

    <!-- ✅ Feedback messages -->
    <?php if (isset($_GET['added'])): ?>
        <div class="message success">✅ Category added successfully!</div>
    <?php endif; ?>

    <?php if (isset($_GET['deleted'])): ?>
        <div class="message deleted">🗑️ Category deleted!</div>
    <?php endif; ?>

    <!-- ✅ Add new category -->
    <form method="post">
        <input type="text" name="category_name" placeholder="New category name" required>
        <button type="submit">Add Category</button>
    </form>

    <!-- ✅ Category list -->
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>

        <?php while ($cat = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= htmlspecialchars($cat['id']) ?></td>
            <td><?= htmlspecialchars($cat['name']) ?></td>
            <td>
                <a href="?delete=<?= $cat['id'] ?>" onclick="return confirm('Are you sure you want to delete this category?');">🗑 Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="admin_dashboard.php" class="back-link">⬅ Back to Dashboard</a>

</body>
</html>
