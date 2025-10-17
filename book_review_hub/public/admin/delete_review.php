<?php
session_start();
require '../../src/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: ../index.php");
    exit();
}

// Make sure the required parameters are passed via GET
if (!isset($_GET['person_id']) || !isset($_GET['book_id'])) {
    echo "Invalid request: missing parameters.";
    exit;
}

$personId = (int)$_GET['person_id'];
$bookId = (int)$_GET['book_id'];

// Update the review to mark it as "In Delete Process"
$stmt = $pdo->prepare("DELETE FROM review WHERE Person_ID = ? AND Book_ID = ?");
$success = $stmt->execute([$personId, $bookId]);

if ($success) {
    // Redirect back to admin_reviews.php or previous page
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'reviews.php'));
    exit;
} else {
    echo "Failed to delete review.";
}
?>