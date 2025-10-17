<?php
require_once "db_connection.php";
session_start();
<?php
session_start();
require 'config.php';

if (!isset($_GET['book_id'])) {
    echo json_encode(['error' => 'Missing book ID']);
    exit;
}

$bookId = (int)$_GET['book_id'];

$stmt = $pdo->prepare("SELECT r.*, p.Username AS reviewer_name, rt.Rating AS review_rating 
    FROM Review r 
    JOIN Person p ON r.Person_ID = p.Person_ID 
    LEFT JOIN Rating rt ON r.Person_ID = rt.Person_ID AND r.Book_ID = rt.Book_ID 
    WHERE r.Book_ID = ? AND r.InDltProcess = 0 
    ORDER BY r.Review_Date DESC");
$stmt->execute([$bookId]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($reviews);


header('Content-Type: application/json');

$bookId = $_GET['book_id'] ?? 0;
$bookId = intval($bookId);

// Fetch all reviews for the given book ID
$stmt = $conn->prepare("
    SELECT r.id, r.user_id, r.rating, r.review, r.spoiler, r.created_at AS date, u.username
    FROM reviews r
    JOIN users u ON r.user_id = u.id
    WHERE r.book_id = ?
    ORDER BY r.created_at DESC
");
$stmt->bind_param("i", $bookId);
$stmt->execute();

$result = $stmt->get_result();
$reviews = [];

while ($row = $result->fetch_assoc()) {
    $reviews[] = [
        'id' => $row['id'],
        'user_id' => $row['user_id'],
        'username' => $row['username'],
        'rating' => $row['rating'],
        'review' => $row['review'],
        'spoiler' => $row['spoiler'],
        'date' => date('Y-m-d', strtotime($row['date']))
    ];
}

echo json_encode($reviews);
exit;
