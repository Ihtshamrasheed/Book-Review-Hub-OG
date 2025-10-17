<!-- header.php -->
<header class="site-header d-flex justify-content-between align-items-center">
  <a href="home.php" class="logo">Review Hub</a>
  <form action="home.php" method="get" class="w-50 mx-3">
    <input type="text" name="search" class="form-control search-bar" placeholder="Search books, authors..." >
  </form>
  <?php if(isset($_SESSION['user_id'])): ?>
    <a href="profile.php" class="profile-link"><?= htmlspecialchars($_SESSION['user_name']) ?>'s Profile</a>
      <a href="../logout.php" class="logout-btn pfd" onclick="return confirmLogout()">Logout</a>

  <?php else: ?>
    <a href="../index.php" class="profile-link">Login</a>
  <?php endif; ?>
</header>
<script>
function confirmLogout() {
  return confirm("Are you sure you want to log out?");
}
</script>