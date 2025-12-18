<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Quiz App</title>
<link rel="stylesheet" href="/quiz_app/assets/style.css">
</head>
<body>

<header class="topbar">
  <div class="logo">
  <a href="/quiz_app/dashboard.php" class="logo-link">
  🧠 Quiz App
  </a>
</div>


  <div class="top-actions">
    <button id="darkToggle" class="btn btn-outline">🌙</button>

    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="/quiz_app/create_quiz.php" class="btn btn-primary">+ Create Quiz</a>
      <a href="/quiz_app/auth/logout.php" class="btn btn-danger">Logout</a>
    <?php endif; ?>
  </div>
</header>
