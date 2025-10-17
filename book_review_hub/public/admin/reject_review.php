<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: admin_reviews.php");
    exit();
}

$review_id = $_GET['id'];
$stmt = $pdo->prepare("UPDATE Review SET Status = 'rejected' WHERE Review_ID = ?");
$stmt->execute([$review_id]);

header("Location: admin_reviews.php");
exit();
