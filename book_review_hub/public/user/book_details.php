<?php
session_start();
require '../../src/config.php';

// Validate book id from GET parameter "id"
if (!isset($_GET['id'])) {
    header("Location: home.php");
    exit;
}
$bookId = (int)$_GET['id'];

// Fetch book details from Book table
$stmt = $pdo->prepare("SELECT * FROM book WHERE Book_ID = ?");
$stmt->execute([$bookId]);
$book = $stmt->fetch();
if (!$book) {
    echo "Book not found.";
    exit;
}

// Fetch genres (assuming stored as comma-separated values in Genre field)
$genres = explode(',', $book['Genre']);

// Fetch reviews from Review table with individual rating (if available)
// Pagination Logic
$maxReviews = 1000;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $maxReviews;


// Count total reviews
$stmt = $pdo->prepare("SELECT COUNT(*) FROM review WHERE Book_ID = ? AND InDltProcess = 0");
$stmt->execute([$bookId]);
$totalReviews = (int)$stmt->fetchColumn();
$totalPages = ceil($totalReviews / $maxReviews);

// Fetch paginated reviews
$stmt = $pdo->prepare("SELECT r.*, p.Username AS reviewer_name, rt.Rating AS review_rating
    FROM review r
    JOIN person p ON r.Person_ID = p.Person_ID
    LEFT JOIN rating rt ON r.Person_ID = rt.Person_ID AND r.Book_ID = rt.Book_ID
    WHERE r.Book_ID = ? AND r.InDltProcess = 0
    ORDER BY r.Review_Date DESC
    LIMIT ? OFFSET ?");

$stmt->bindValue(1, $bookId, PDO::PARAM_INT);
$stmt->bindValue(2, $maxReviews, PDO::PARAM_INT);
$stmt->bindValue(3, $offset, PDO::PARAM_INT);
$stmt->execute();
$reviews = $stmt->fetchAll();


// Check if the logged-in user has already posted a review for this book
$userReview = false;
$userRating = null;
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM review WHERE Book_ID = ? AND Person_ID = ?");
    $stmt->execute([$bookId, $_SESSION['user_id']]);
    $userReview = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT Rating FROM rating WHERE Book_ID = ? AND Person_ID = ?");
    $stmt->execute([$bookId, $_SESSION['user_id']]);
    $ratingRow = $stmt->fetch();
    $userRating = $ratingRow ? $ratingRow['Rating'] : null;
}

// Check if the book is in the wishlist of the logged-in user
$inWishlist = false;
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM wishlist WHERE Person_ID = ? AND Book_ID = ?");
    $stmt->execute([$_SESSION['user_id'], $bookId]);
    $inWishlist = $stmt->fetch() ? true : false;
}

include '../../templates/user/book_details.php';
?>