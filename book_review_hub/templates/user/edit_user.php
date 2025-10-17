<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/styles.css">
  <link rel="stylesheet" href="../../public/css/header.css">
    <style>
        .content { max-width: 600px; margin: auto; padding-top: 80px; }
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
            warning.style.display = (newPass && confirmPass && newPass !== confirmPass) ? 'block' : 'none';
        }
    </script>
</head>
<body>
<?php include '../../src/includes/header.php'; ?>

<div class="content container">
    <h3>Edit Your Profile</h3>

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

        <button type="button" class="btn btn-warning mb-3 logout-btn" onclick="togglePasswordFields()">Change Password</button>

        <div id="passwordFields">
            <div class="form-group">
                <label>New Password:</label>
                <input type="password" name="new_password" class="form-control" id="new_password">
            </div>
            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" name="confirm_password" class="form-control" id="confirm_password">
            </div>
            <div id="passwordMismatch" class="password-warning">Passwords do not match!</div>
        </div>
<div class="d-flex float-right">
        <button type="submit" class="btn btn-primary mt-3 mr-1 logout-btn">Save Changes</button>
        <a href="profile.php" class="btn btn-secondary mt-3 logout-btn">Cancel</a>
    </div>
    </form>
</div>
</body>
</html>