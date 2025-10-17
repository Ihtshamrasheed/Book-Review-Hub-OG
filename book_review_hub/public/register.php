<?php
session_start();
require '../src/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check if email exists
    $stmt = $pdo->prepare("SELECT * FROM person WHERE Email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $error = "Email already exists.";
    } else {
        // Insert new user without specifying the ID (it will auto-increment)
        $stmt = $pdo->prepare("INSERT INTO person (Username, Join_Date, Email, Role, Password)
                               VALUES (?, NOW(), ?, 0, ?)");
        $stmt->execute([$username, $email, $password]);

        // Get the last inserted ID
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['user_name'] = $username;
        $_SESSION['role'] = 0; // Set role to user
        $_SESSION['user_email'] = $email;

        header("Location: user/home.php");
        exit;
    }
}

// Include the register template
include '../templates/register.php';
?>