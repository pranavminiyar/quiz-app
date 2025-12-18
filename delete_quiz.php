<?php
session_start();
include "config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

if ($quiz['user_id'] != $_SESSION['user_id']) {
    die("Unauthorized access");
}

$id = (int) $_GET['id'];
$user_id = $_SESSION['user_id'];

// delete only if creator
mysqli_query(
    $conn,
    "DELETE FROM quizzes WHERE id='$id' AND user_id='$user_id'"
);

header("Location: dashboard.php");
exit;
