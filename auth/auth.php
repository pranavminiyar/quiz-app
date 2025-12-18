<?php
session_start();
include "../config/db.php";
include "../assets/header.php";

if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $login    = trim($_POST['login']); // username OR email
    $password = $_POST['password'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM users 
         WHERE username='$login' OR email='$login'
         LIMIT 1"
    );

    if (mysqli_num_rows($query) === 1) {
        $user = mysqli_fetch_assoc($query);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: ../dashboard.php");
            exit;
        }
    }

    $error = "❌ Invalid login credentials";
}
?>

<div class="auth-container">
  <div class="auth-card">

    <h2 class="auth-title">Welcome Back 👋</h2>
    <p class="auth-subtitle">Login to Quiz App</p>

    <?php if ($error): ?>
      <div class="error-msg"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
      <input type="text" name="login" placeholder="Username or Email" required>
      <input type="password" name="password" placeholder="Password" required>

      <button class="btn btn-primary btn-block">Login</button>
    </form>

    <p class="auth-footer">
      Don’t have an account?
      <a href="register.php">Register</a>
    </p>

  </div>
</div>

<?php include "../assets/footer.php"; ?>
