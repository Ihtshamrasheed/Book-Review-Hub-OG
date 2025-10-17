<nav class="bg-light sidebar">
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link <?= ($activePage == 'dashboard') ? 'active' : '' ?>" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link <?= ($activePage == 'books') ? 'active' : '' ?>" href="books.php">Books</a></li>
        <li class="nav-item"><a class="nav-link <?= ($activePage == 'users') ? 'active' : '' ?>" href="users.php">Users</a></li>
     <li class="nav-item"><a class="nav-link <?= ($activePage == 'reviews') ? 'active' : '' ?>" href="reviews.php">Reviews</a></li>
<li class="nav-item">
  <a class="nav-link <?= ($activePage == 'logout') ? 'active' : '' ?>" href="../logout.php" onclick="return confirmLogout()">Logout</a>
</li>

    </ul>
</nav>
<script>
function confirmLogout() {
  return confirm("Are you sure you want to log out?");
}
</script>