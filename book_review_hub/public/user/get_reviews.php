<?php
session_start();
require '../../src/config.php';

if (!isset($_GET['book_id'])) {
    echo json_encode(['error' => 'Missing book ID']);
    exit;
}

$bookId = (int)$_GET['book_id'];

$stmt = $pdo->prepare("SELECT r.*, p.Username AS reviewer_name, rt.Rating AS review_rating
    FROM review r
    JOIN person p ON r.Person_ID = p.Person_ID
    LEFT JOIN rating rt ON r.Person_ID = rt.Person_ID AND r.Book_ID = rt.Book_ID
    WHERE r.Book_ID = ? AND r.InDltProcess = 0
    ORDER BY r.Review_Date DESC");
$stmt->execute([$bookId]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($reviews);
?>