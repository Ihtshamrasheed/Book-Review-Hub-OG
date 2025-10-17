<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Review Hub</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- External CSS file for register.php -->
  <link rel="stylesheet" href="css/register.css">
  <link rel="stylesheet" href="css/styles.css">

</head>
<body>
  <div class="container mt-5">
    <h1 class="logo">Register for Review Hub</h1>
    <?php if(isset($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="register.php">
      <div class="form-group">
        <label>Username:</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Password:</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary sbm">Register</button>
    </form>
    <p class="mt-3">Already have an account? <a href="index.php">Login Here</a></p>
  </div>
</body>
</html>