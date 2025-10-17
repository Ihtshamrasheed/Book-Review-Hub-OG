<?php
include 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request.");
}

$personId = (int)$_GET['id'];

// Fetch current role
$stmt = $pdo->prepare("SELECT Role FROM person WHERE Person_id = ?");
$stmt->execute([$personId]);
$user = $stmt->fetch();

if (!$user) {
    die("User not found.");
}

$newRole = $user['Role'] == 1 ? 0 : 1;

$update = $pdo->prepare("UPDATE person SET Role = ? WHERE Person_id = ?");
$update->execute([$newRole, $personId]);

header("Location: admin_users.php");
exit;
