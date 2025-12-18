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

    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (!$username || !$email || !$password) {
        $error = "⚠ All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "⚠ Invalid email address";
    } elseif (strlen($password) < 5) {
        $error = "⚠ Password must be at least 5 characters";
    } else {

        // Check duplicate username or email
        $check = mysqli_query(
            $conn,
            "SELECT id FROM users WHERE username='$username' OR email='$email'"
        );

        if (mysqli_num_rows($check) > 0) {
            $error = "⚠ Username or email already exists";
        } else {

            $hashed = password_hash($password, PASSWORD_DEFAULT);

            mysqli_query(
                $conn,
                "INSERT INTO users (username, email, password)
                 VALUES ('$username', '$email', '$hashed')"
            );

            $_SESSION['user_id'] = mysqli_insert_id($conn);
            $_SESSION['username'] = $username;

            header("Location: ../dashboard.php");
            exit;
        }
    }
}
?>

<div class="auth-container">
  <div class="auth-card">

    <h2 class="auth-title">Create Account ✨</h2>
    <p class="auth-subtitle">Join Quiz App</p>

    <?php if ($error): ?>
      <div class="error-msg"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="email" name="email" placeholder="Email address" required>
      <input type="password" name="password" placeholder="Password" required>

      <button class="btn btn-primary btn-block">Register</button>
    </form>

    <p class="auth-footer">
      Already have an account?
      <a href="login.php">Login</a>
    </p>

  </div>
</div>

<?php include "../assets/footer.php"; ?>
