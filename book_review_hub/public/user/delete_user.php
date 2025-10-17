<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: admin_users.php");
    exit();
}

$user_id = $_GET['id'];

// Delete user (ensure foreign key constraints are considered)
$stmt = $pdo->prepare("DELETE FROM Person WHERE Person_ID = ?");
$stmt->execute([$user_id]);

header("Location: admin_users.php");
exit();
