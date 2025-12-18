<?php
session_start();
include "config/db.php";
include "assets/header.php";

if (!isset($_GET['quiz_id'])) {
    echo "Quiz not found";
    exit;
}

$quiz_id = (int)$_GET['quiz_id'];

$questions = mysqli_query(
    $conn,
    "SELECT * FROM questions WHERE quiz_id = $quiz_id"
);
?>

<div class="container">
  <h2 class="page-title">Take Quiz</h2>

  <form method="POST" action="result.php?quiz_id=<?php echo $quiz_id; ?>">

    <?php $qno = 1; while ($q = mysqli_fetch_assoc($questions)): ?>

      <div class="card" style="flex-direction:column; align-items:flex-start;">
        <strong>
          Q<?php echo $qno++; ?>. <?php echo htmlspecialchars($q['question']); ?>
        </strong>

        <div style="margin-top:12px; display:flex; flex-direction:column; gap:8px;">

          <label>
            <input type="radio"
                   name="answer[<?php echo $q['id']; ?>]"
                   value="1"
                   required>
            <?php echo htmlspecialchars($q['option1']); ?>
          </label>

          <label>
            <input type="radio"
                   name="answer[<?php echo $q['id']; ?>]"
                   value="2">
            <?php echo htmlspecialchars($q['option2']); ?>
          </label>

          <label>
            <input type="radio"
                   name="answer[<?php echo $q['id']; ?>]"
                   value="3">
            <?php echo htmlspecialchars($q['option3']); ?>
          </label>

          <label>
            <input type="radio"
                   name="answer[<?php echo $q['id']; ?>]"
                   value="4">
            <?php echo htmlspecialchars($q['option4']); ?>
          </label>

        </div>
      </div>

    <?php endwhile; ?>

    <button class="btn btn-primary" style="margin-top:20px;">
      Submit Quiz
    </button>
  </form>
</div>

<?php include "assets/footer.php"; ?>
