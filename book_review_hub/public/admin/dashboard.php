<?php
session_start();
require '../../src/config.php';

// Ensure user is logged in and is admin (role = 1)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: ../../public/index.php");
    exit();
}
$activePage = 'dashboard';

// Fetch statistics
$totalBooks = $pdo->query("SELECT COUNT(*) FROM book")->fetchColumn();
$totalUsers = $pdo->query("SELECT COUNT(*) FROM person WHERE Role = 0")->fetchColumn();
$totalReviews = $pdo->query("SELECT COUNT(*) FROM review")->fetchColumn();

include '../../templates/admin/dashboard.php';
?>