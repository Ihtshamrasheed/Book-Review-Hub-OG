<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../public/css/sidebar.css">
    <link rel="stylesheet" href="../../public/css/styles.css">
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
<?php include '../../src/includes/admin_sidebar.php'; ?>
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
        <a href="<?= $isSelfEdit ? 'dashboard.php' : 'users.php' ?>" class="btn btn-secondary mt-3">Cancel</a>
    </div>
    </form>
</div>
</body>
</html>