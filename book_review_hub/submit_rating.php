<?php
session_start();
require 'config.php';

$response = ['success' => false];

if (isset($_SESSION['user_id'], $_POST['book_id'], $_POST['rating'])) {
    $userId = $_SESSION['user_id'];
    $bookId = (int)$_POST['book_id'];
    $rating = (int)$_POST['rating'];

    try {
        // Check if rating exists for this user-book pair
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM Rating WHERE Book_ID = ? AND Person_ID = ?");
        $checkStmt->execute([$bookId, $userId]);

        if ($checkStmt->fetchColumn() > 0) {
            // Update existing rating
            $stmt = $pdo->prepare("UPDATE Rating SET Rating = ? WHERE Book_ID = ? AND Person_ID = ?");
            $stmt->execute([$rating, $bookId, $userId]);
        } else {
            // Insert new rating
            $stmt = $pdo->prepare("INSERT INTO Rating (Book_ID, Person_ID, Rating) VALUES (?, ?, ?)");
            $stmt->execute([$bookId, $userId, $rating]);
        }

        // Recalculate the average rating for the book
        $avgStmt = $pdo->prepare("SELECT AVG(Rating) AS avg_rating FROM Rating WHERE Book_ID = ?");
        $avgStmt->execute([$bookId]);
        $avgRating = round($avgStmt->fetchColumn(), 1);

        // Recalculate the total number of unique raters
        $countStmt = $pdo->prepare("SELECT COUNT(DISTINCT Person_ID) FROM Rating WHERE Book_ID = ?");
        $countStmt->execute([$bookId]);
        $ratingUserCount = $countStmt->fetchColumn();

        // Update the Book table with the new average rating and user count
        $updateBook = $pdo->prepare("UPDATE Book SET Curr_Rating = ?, Rating_User_Count = ? WHERE Book_ID = ?");
        $updateBook->execute([$avgRating, $ratingUserCount, $bookId]);

        $response['success'] = true;
        $response['new_avg'] = $avgRating;
        $response['user_count'] = $ratingUserCount;

    } catch (PDOException $e) {
        $response['success'] = false;
        $response['error'] = 'Database error: ' . $e->getMessage();
    }
} else {
    $response['error'] = 'Missing required fields or user not logged in.';
}

echo json_encode($response);
?>
