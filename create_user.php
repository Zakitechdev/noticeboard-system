<?php
session_start();

// Check if the logged-in user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <style>
        body {
            margin: 0;
            background-color: #EDC9AF; /* desert sand */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
            color: #444;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            margin-top: 20px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #388E3C;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Create New User</h2>
        <form action="submit_user.php" method="post">
            <label>Name:</label>
            <input type="text" name="name" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <label>Role:</label>
            <select name="role" required>
                <option value="staff">Staff</option>
                <option value="viewer">Viewer</option>
            </select>

            <button type="submit">Create User</button>
        </form>
    </div>
    
<a href="admin_dashboard.php" class="back-link">⬅ Back to Dashboard</a>

</body>
</html>
