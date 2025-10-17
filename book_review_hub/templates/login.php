<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Review Hub</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- External CSS for index.php -->
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/styles.css">

</head>
<body>
  <div class="container mt-5">
    <h1 class="logo">Review Hub - Login</h1>
    <?php if(isset($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="index.php">
      <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Password:</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary sbm">Login</button>
    </form>
    <p class="mt-3">Don't have an account? <a href="register.php">Register Here</a></p>
  </div>
</body>
</html>