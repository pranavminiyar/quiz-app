<?php
session_start();
include "config/db.php";
include "assets/header.php";

$quiz_id = $_GET['quiz_id'] ?? 0;
$score = 0;
$total = 0;

/* Fetch correct answers */
$questions = mysqli_query(
    $conn,
    "SELECT id, correct_option FROM questions WHERE quiz_id = $quiz_id"
);

while ($q = mysqli_fetch_assoc($questions)) {
    $total++;

    // ✅ FIXED HERE: 'answer' instead of 'ans'
    if (
        isset($_POST['answer'][$q['id']]) &&
        $_POST['answer'][$q['id']] == $q['correct_option']
    ) {
        $score++;
    }
}

$percentage = ($total > 0) ? round(($score / $total) * 100) : 0;
?>

<div class="container">
  <div class="card" style="flex-direction:column; align-items:center;">

    <h2>📊 Quiz Result</h2>

    <p style="font-size:18px;">
      Score:
      <strong><?php echo $score; ?></strong> /
      <strong><?php echo $total; ?></strong>
    </p>

    <div style="width:100%; background:#e5e7eb; border-radius:10px; overflow:hidden; margin:10px 0;">
      <div style="
        width: <?php echo $percentage; ?>%;
        background: <?php echo ($percentage >= 50 ? '#22c55e' : '#ef4444'); ?>;
        padding:8px;
        color:white;
        text-align:center;
        font-weight:bold;
      ">
        <?php echo $percentage; ?>%
      </div>
    </div>

    <?php if ($percentage >= 50): ?>
      <p style="color:green; font-weight:bold;">🎉 Great job! You passed.</p>
    <?php else: ?>
      <p style="color:red; font-weight:bold;">❌ Keep practicing. You can do better!</p>
    <?php endif; ?>

    <a href="dashboard.php" class="btn btn-primary" style="margin-top:10px;">
      ← Back to Dashboard
    </a>

  </div>
</div>

<?php include "assets/footer.php"; ?>
