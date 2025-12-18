<?php
session_start();
include "config/db.php";
include "assets/header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

$quiz_id = (int) ($_GET['quiz_id'] ?? 0);
$success = false;

// verify quiz belongs to user
$check = mysqli_query(
    $conn,
    "SELECT * FROM quizzes WHERE id='$quiz_id' AND user_id='{$_SESSION['user_id']}'"
);

if (mysqli_num_rows($check) === 0) {
    echo "<p style='color:red;text-align:center;'>Invalid quiz access</p>";
    include "assets/footer.php";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $q  = trim($_POST['question']);
    $o1 = trim($_POST['opt1']);
    $o2 = trim($_POST['opt2']);
    $o3 = trim($_POST['opt3']);
    $o4 = trim($_POST['opt4']);
    $c  = (int) $_POST['correct'];
    $e  = trim($_POST['explanation']);

    mysqli_query(
        $conn,
        "INSERT INTO questions 
        (quiz_id, question, option1, option2, option3, option4, correct_option, explanation)
        VALUES 
        ('$quiz_id','$q','$o1','$o2','$o3','$o4','$c','$e')"
    );

    $success = true;
}
?>

<div class="container">
  <div class="card question-card">

    <h2 class="page-title">➕ Add Question</h2>

    <?php if ($success): ?>
      <p style="color:green;">✅ Question added successfully</p>
    <?php endif; ?>

    <form method="POST">

      <div class="form-group">
        <label>Question</label>
        <textarea name="question" required placeholder="Enter your question"></textarea>
      </div>

      <div class="options-grid">
        <input type="text" name="opt1" placeholder="Option 1" required>
        <input type="text" name="opt2" placeholder="Option 2" required>
        <input type="text" name="opt3" placeholder="Option 3" required>
        <input type="text" name="opt4" placeholder="Option 4" required>
      </div>

      <div class="form-group">
        <label>Correct Answer</label>
        <select name="correct" required>
          <option value="">Select correct option</option>
          <option value="1">Option 1</option>
          <option value="2">Option 2</option>
          <option value="3">Option 3</option>
          <option value="4">Option 4</option>
        </select>
      </div>

      <div class="form-group">
        <label>Explanation (optional)</label>
        <textarea name="explanation" placeholder="Explain why this answer is correct"></textarea>
      </div>

      <div class="form-actions">
        <button class="btn btn-primary">Add Question</button>
        <a href="dashboard.php" class="link">Finish Quiz</a>
      </div>

    </form>
  </div>
</div>

<?php include "assets/footer.php"; ?>
