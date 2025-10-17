<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'You must be logged in to post a review.']);
        exit;
    }

    $personId = $_SESSION['user_id'];
    $bookId = (int)$_POST['book_id'];
    $subject = trim($_POST['subject']);
    $content = trim($_POST['content']);
    $containsSpoilers = isset($_POST['contains_spoilers']) ? 1 : 0;

    if ($subject === "" || $content === "") {
        echo json_encode(['status' => 'error', 'message' => 'Subject and content cannot be empty.']);
        exit;
    }

    // Insert or update review
    $stmt = $pdo->prepare("INSERT INTO Review (Person_ID, Book_ID, Title, Content, Contains_Spoilers, Review_Date, InDltProcess)
                           VALUES (?, ?, ?, ?, ?, NOW(), 0)
                           ON DUPLICATE KEY UPDATE Title = VALUES(Title), Content = VALUES(Content), Contains_Spoilers = VALUES(Contains_Spoilers), Review_Date = NOW()");
    try {
        $stmt->execute([$personId, $bookId, $subject, $content, $containsSpoilers]);
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error saving review.']);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>