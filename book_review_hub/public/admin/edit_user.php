<?php
session_start();
require '../../src/config.php';

$activePage = 'users';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Determine context
if (isset($_GET['id'])) {
    if ($_SESSION['role'] != 1) {
        header("Location: ../index.php");
        exit();
    }
    $user_id = $_GET['id'];
    $isSelfEdit = false;
} else {
    $user_id = $_SESSION['user_id'];
    $isSelfEdit = true;
}

// Handle form submission
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $stmt = $pdo->prepare("UPDATE person SET Username = ?, Email = ? WHERE Person_ID = ?");
    $stmt->execute([$name, $email, $user_id]);

    if ($isSelfEdit) {
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
    }

    if (!empty($newPassword) || !empty($confirmPassword)) {
    if ($newPassword === $confirmPassword) {
$hashed = $newPassword;

        $stmt = $pdo->prepare("UPDATE person SET Password = ? WHERE Person_ID = ?");
        $stmt->execute([$hashed, $user_id]);
    } else {
        $error = "Passwords do not match.";
    }
}


    if (!$error) {
        header("Location: " . ($isSelfEdit ? 'dashboard.php' : 'users.php'));
        exit();
    }
}

// Fetch user info
$stmt = $pdo->prepare("SELECT * FROM person WHERE Person_ID = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    header("Location: users.php");
    exit();
}

include '../../templates/admin/edit_user.php';
?>