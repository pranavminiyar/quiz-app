<?php
session_start();
include "config/db.php";
include "assets/header.php";

// user must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST['title']);
    $time  = (int) $_POST['time_limit'];
    $user_id = $_SESSION['user_id'];

    if ($title !== "" && $time > 0) {

        mysqli_query(
            $conn,
            "INSERT INTO quizzes (user_id, title, time_limit)
             VALUES ('$user_id', '$title', '$time')"
        );

        $quiz_id = mysqli_insert_id($conn);

        header("Location: add_questions.php?quiz_id=$quiz_id");
        exit;
    }
}
?>

<div class="container">
  <div class="card" style="max-width:600px;margin:auto;">
    <h2 class="page-title">➕ Create New Quiz</h2>

    <form method="POST">

      <div class="form-group">
        <label>Quiz Title</label>
        <input type="text" name="title" placeholder="Enter quiz title" required>
      </div>

      <div class="form-group">
        <label>Time Limit (minutes)</label>
        <input type="number" name="time_limit" placeholder="Example: 10" required>
      </div>

      <button class="btn btn-primary">Create Quiz</button>
      <br><br>
      <a href="dashboard.php" class="link">← Back to Dashboard</a>

    </form>
  </div>
</div>

<?php include "assets/footer.php"; ?>
