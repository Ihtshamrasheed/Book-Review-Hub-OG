<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/styles.css">
  <link rel="stylesheet" href="../../public/css/sidebar.css">

  <style>
    body { display: flex; min-height: 100vh; }

    .content {
        margin-left: 60px;
        margin-right: 60px;
        padding-top: 80px;
        padding: 20px;
        flex-grow: 1;
    }
    .top-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
  </style>
</head>
<body>

<?php include '../../src/includes/admin_sidebar.php'; ?>

<div class="content">
  <div class="top-info mb-4">
  <div>
    <h4><strong>Admin:</strong> <?= htmlspecialchars($_SESSION['user_name']); ?></h4>
    <p class="text-muted mb-0"><?= htmlspecialchars($_SESSION['user_email']); ?></p>
  </div>
  <a href="admin_edit_user.php" class="btn btn-secondary btn-sm">Edit Profile</a>
</div>


  <h4>Statistics Overview</h4>
  <div class="row mt-3">
    <div class="col-md-4">
      <div class="card bg-light p-3">
        <h5>Total Books</h5>
        <p><?= $totalBooks; ?></p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-light p-3">
        <h5>Total Users</h5>
        <p><?= $totalUsers; ?></p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-light p-3">
        <h5>Total Reviews</h5>
        <p><?= $totalReviews; ?></p>
      </div>
    </div>
  </div>
</div>

</body>
</html>