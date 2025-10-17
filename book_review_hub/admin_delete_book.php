<?php
session_start();
require 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: admin_books.php");
    exit;
}

$bookId = intval($_GET['id']);

// First, delete related entries (if applicable, to maintain referential integrity)
$pdo->prepare("DELETE FROM Wishlist WHERE Book_ID = ?")->execute([$bookId]);
$pdo->prepare("DELETE FROM Rating WHERE Book_ID = ?")->execute([$bookId]);
$pdo->prepare("DELETE FROM Review WHERE Book_ID = ?")->execute([$bookId]);

// Now delete the book itself
$pdo->prepare("DELETE FROM Book WHERE Book_ID = ?")->execute([$bookId]);

// Redirect back to books page
header("Location: admin_books.php");
exit;
