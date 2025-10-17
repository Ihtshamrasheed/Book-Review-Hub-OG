<?php
session_start();
require '../../src/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: books.php");
    exit;
}

$bookId = intval($_GET['id']);

// First, delete related entries (if applicable, to maintain referential integrity)
$pdo->prepare("DELETE FROM wishlist WHERE Book_ID = ?")->execute([$bookId]);
$pdo->prepare("DELETE FROM rating WHERE Book_ID = ?")->execute([$bookId]);
$pdo->prepare("DELETE FROM review WHERE Book_ID = ?")->execute([$bookId]);
$pdo->prepare("DELETE FROM book_genres WHERE Book_ID = ?")->execute([$bookId]);


// Now delete the book itself
$pdo->prepare("DELETE FROM book WHERE Book_ID = ?")->execute([$bookId]);

// Redirect back to books page
header("Location: books.php");
exit;
?>