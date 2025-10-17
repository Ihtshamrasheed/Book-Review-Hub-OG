<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require '../src/config.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 1) {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: user/home.php");
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check in Person table (using Email and Password)
    $stmt = $pdo->prepare("SELECT * FROM person WHERE Email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $password === $user['Password']) {
        $_SESSION['user_id'] = $user['Person_ID'];
        $_SESSION['user_name'] = $user['Username'];
        $_SESSION['role'] = $user['Role'];
        $_SESSION['user_email'] = $user['Email'];

        if ($user['Role'] == 1) {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: user/home.php");
        }
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}

// Include the login template
include '../templates/login.php';
?>