<?php
session_start();
require 'config.php';

$activePage = 'users';

include 'admin_header.php';
include 'admin_sidebar.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Determine context
if (isset($_GET['id'])) {
    if ($_SESSION['role'] != 1) {
        header("Location: index.php");
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

    $stmt = $pdo->prepare("UPDATE Person SET Username = ?, Email = ? WHERE Person_ID = ?");
    $stmt->execute([$name, $email, $user_id]);

    if ($isSelfEdit) {
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
    }

    if (!empty($newPassword) || !empty($confirmPassword)) {
    if ($newPassword === $confirmPassword) {
$hashed = $newPassword;

        $stmt = $pdo->prepare("UPDATE Person SET Password = ? WHERE Person_ID = ?");
        $stmt->execute([$hashed, $user_id]);
    } else {
        $error = "Passwords do not match.";
    }
}


    if (!$error) {
        header("Location: " . ($isSelfEdit ? 'admin_dashboard.php' : 'admin_users.php'));
        exit();
    }
}

// Fetch user info
$stmt = $pdo->prepare("SELECT * FROM Person WHERE Person_ID = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    header("Location: admin_users.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body { display: flex; min-height: 100vh; }
        .content { padding-top: 80px; padding: 20px; flex-grow: 1; }
        #passwordFields { display: none; }
        .password-warning { color: red; font-size: 0.9em; display: none; }
    </style>
    <script>
        function togglePasswordFields() {
            const fields = document.getElementById('passwordFields');
            fields.style.display = (fields.style.display === 'block') ? 'none' : 'block';
        }

        function validatePasswords() {
            const newPass = document.getElementById('new_password').value;
            const confirmPass = document.getElementById('confirm_password').value;
            const warning = document.getElementById('passwordMismatch');
            if (newPass && confirmPass && newPass !== confirmPass) {
                warning.style.display = 'block';
            } else {
                warning.style.display = 'none';
            }
        }
    </script>
</head>
<body>
<div class="content container mt-4">
    <h3><?= $isSelfEdit ? 'Edit Your Profile' : 'Edit User' ?></h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" oninput="validatePasswords()">
        <div class="form-group">
            <label>Name:</label>
            <input class="form-control" name="name" value="<?= htmlspecialchars($user['Username']) ?>" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['Email']) ?>" required>
        </div>

        <button type="button" class="btn btn-warning mb-3" onclick="togglePasswordFields()">Change Password</button>
        
        <div id="passwordFields">
            <div class="form-group">
                <label>New Password:</label>
                <input type="password" id="new_password" name="new_password" class="form-control">
            </div>
            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control">
            </div>
            <div id="passwordMismatch" class="password-warning">Passwords do not match!</div>
        </div>
<div class="d-flex float-right">
        <button class="btn btn-primary mt-3 mr-1">Save Changes</button>
        <a href="<?= $isSelfEdit ? 'admin_dashboard.php' : 'admin_users.php' ?>" class="btn btn-secondary mt-3">Cancel</a>
    </div>
    </form>
</div>
</body>
</html>
