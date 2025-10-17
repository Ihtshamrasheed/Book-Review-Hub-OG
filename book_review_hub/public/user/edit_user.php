<?php
session_start();
require '../../src/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $stmt = $pdo->prepare("UPDATE person SET Username = ?, Email = ? WHERE Person_ID = ?");
    $stmt->execute([$name, $email, $user_id]);

    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;

    if (!empty($newPassword) || !empty($confirmPassword)) {
        if ($newPassword === $confirmPassword) {
            $hashed = $newPassword; // Plaintext password (not secure)
            $stmt = $pdo->prepare("UPDATE person SET Password = ? WHERE Person_ID = ?");
            $stmt->execute([$hashed, $user_id]);
        } else {
            $error = "Passwords do not match.";
        }
    }

    if (!$error) {
        header("Location: profile.php"); // Redirect to user profile
        exit();
    }
}

// Fetch user info
$stmt = $pdo->prepare("SELECT * FROM person WHERE Person_ID = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    header("Location: ../index.php");
    exit();
}

include '../../templates/user/edit_user.php';
?>