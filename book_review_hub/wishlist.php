<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'You must be logged in.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $personId = $_SESSION['user_id'];
    $bookId = (int)$_POST['book_id'];

    // Check if the wishlist entry exists
    $stmt = $pdo->prepare("SELECT * FROM Wishlist WHERE Person_ID = ? AND Book_ID = ?");
    $stmt->execute([$personId, $bookId]);
    $exists = $stmt->fetch();

    if ($exists) {
        // Remove from wishlist
        $stmt = $pdo->prepare("DELETE FROM Wishlist WHERE Person_ID = ? AND Book_ID = ?");
        $stmt->execute([$personId, $bookId]);
        echo json_encode(['status' => 'removed']);
    } else {
        // Add to wishlist
        $stmt = $pdo->prepare("INSERT INTO Wishlist (Person_ID, Book_ID) VALUES (?, ?)");
        $stmt->execute([$personId, $bookId]);
        echo json_encode(['status' => 'added']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
