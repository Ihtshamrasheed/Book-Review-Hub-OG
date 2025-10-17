<?php
require 'config.php';

// Make sure the required parameters are passed via GET
if (!isset($_GET['person_id']) || !isset($_GET['book_id'])) {
    echo "Invalid request: missing parameters.";
    exit;
}

$personId = (int)$_GET['person_id'];
$bookId = (int)$_GET['book_id'];

// Update the review to mark it as "In Delete Process"
$stmt = $pdo->prepare("UPDATE review SET InDltProcess = 1 WHERE Person_ID = ? AND Book_ID = ?");
$success = $stmt->execute([$personId, $bookId]);

if ($success) {
    // Redirect back to admin_reviews.php or previous page
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'admin_reviews.php'));
    exit;
} else {
    echo "Failed to mark review for deletion.";
}
?>
