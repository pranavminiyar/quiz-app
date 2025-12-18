<?php
session_start();
include "config/db.php";
include "assets/header.php";

/* 🔐 Auth check */
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

$current_user_id = $_SESSION['user_id'];

/* 📥 Fetch all quizzes */
$result = mysqli_query($conn, "SELECT * FROM quizzes ORDER BY id DESC");
?>

<div class="container">

  <!-- PAGE HEADER -->
  <div class="page-header">
    <h1 class="page-title">
      Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 🎉
    </h1>
    <p class="page-subtitle">Manage your quizzes below</p>
  </div>

  <!-- QUIZ LIST -->
  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>

      <div class="card quiz-card">

        <!-- LEFT: QUIZ TITLE -->
        <div class="quiz-title">
          <?php echo htmlspecialchars($row['title']); ?>
        </div>

        <!-- RIGHT: ACTIONS (ALWAYS ALIGNED) -->
        <div class="quiz-actions">

          <!-- TAKE QUIZ (EVERYONE) -->
          <a
            href="take_quiz.php?quiz_id=<?php echo $row['id']; ?>"
            class="btn btn-primary"
          >
            ▶ Take Quiz
          </a>

          <!-- CREATOR ACTIONS (ONLY QUIZ OWNER) -->
          <?php if ($row['user_id'] == $current_user_id): ?>
            <div class="creator-actions">

              <a
                href="add_questions.php?quiz_id=<?php echo $row['id']; ?>"
                class="btn btn-secondary"
              >
                ➕ Add Questions
              </a>

              <a
                href="delete_quiz.php?id=<?php echo $row['id']; ?>"
                class="btn btn-danger"
                onclick="return confirm('Delete this quiz permanently?')"
              >
                🗑 Delete
              </a>

            </div>
          <?php endif; ?>

        </div>
      </div>

    <?php endwhile; ?>
  <?php else: ?>

    <div class="card">
      <p class="muted">No quizzes created yet.</p>
    </div>

  <?php endif; ?>

</div>

<?php include "assets/footer.php"; ?>
