<?php
session_start();

// Only allow staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}

include("db connect.php");

$message = "";
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $status = $_POST['status'];
    $scheduled_at = !empty($_POST['scheduled_at']) ? $_POST['scheduled_at'] : null;
    $category_id = intval($_POST['category_id']);
    $author_id = $_SESSION['user_id'];

    if ($title && $content && $category_id) {
        $stmt = $conn->prepare("
            INSERT INTO notices (title, content, status, created_at, scheduled_at, author_id, category_id) 
            VALUES (?, ?, ?, NOW(), ?, ?, ?)
        ");
        $stmt->bind_param("ssssii", $title, $content, $status, $scheduled_at, $author_id, $category_id);

        if ($stmt->execute()) {
            $message = "✅ Notice created successfully!";
        } else {
            $message = "❌ Error: " . $conn->error;
        }
    } else {
        $message = "⚠️ Please fill in all required fields.";
    }
}

// Fetch categories
$categories = [];
$cat_result = $conn->query("SELECT id, name FROM categories ORDER BY name");
while ($row = $cat_result->fetch_assoc()) {
    $categories[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Notice</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      background: linear-gradient(135deg, #fceabb 0%, #f8b500 100%);
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background: #ffffffee;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      max-width: 720px;
      width: 100%;
    }

    h2 {
      text-align: center;
      color: #004d40;
      font-size: 30px;
      margin-bottom: 30px;
    }

    label {
      display: block;
      margin-top: 16px;
      font-weight: 600;
      font-size: 16px;
      color: #333;
    }

    input[type="text"],
    textarea,
    select,
    input[type="datetime-local"] {
      width: 100%;
      padding: 12px;
      margin-top: 6px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
    }

    textarea {
      resize: vertical;
    }

    button {
      margin-top: 25px;
      background-color: #004d40;
      color: white;
      padding: 14px;
      width: 100%;
      border: none;
      border-radius: 8px;
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #00695c;
    }

    .message {
      margin-top: 20px;
      font-weight: bold;
      text-align: center;
      font-size: 16px;
    }

    .success {
      color: green;
    }

    .error {
      color: red;
    }

    .back-link {
      text-align: center;
      display: block;
      margin-top: 25px;
      font-size: 16px;
      color: #004d40;
      text-decoration: none;
      font-weight: 500;
    }

    .back-link:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .container {
        padding: 20px;
        margin: 20px;
      }

      h2 {
        font-size: 24px;
      }

      label {
        font-size: 15px;
      }

      button {
        font-size: 16px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Create New Notice</h2>

  <?php if ($message): ?>
    <div class="message <?= str_contains($message, '✅') ? 'success' : 'error' ?>">
      <?= htmlspecialchars($message) ?>
    </div>
  <?php endif; ?>

  <form method="POST">
    <label for="title">Notice Title</label>
    <input type="text" name="title" id="title" required>

    <label for="content">Notice Content</label>
    <textarea name="content" id="content" rows="6" required></textarea>

    <label for="status">Status</label>
    <select name="status" id="status" required>
      <option value="draft">Draft</option>
      <option value="published">Published</option>
    </select>

    <label for="scheduled_at">Schedule (optional)</label>
    <input type="datetime-local" name="scheduled_at" id="scheduled_at">

    <label for="category_id">Category</label>
    <select name="category_id" id="category_id" required>
      <option value="">-- Select Category --</option>
      <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
      <?php endforeach; ?>
    </select>

    <button type="submit">Publish Notice</button>
  </form>

  <a class="back-link" href="staff_dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
