<?php
session_start();
require '../../src/config.php';
$maxDisplay = 7;
$allDisplay = 100;



if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}
$userId = $_SESSION['user_id'];

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM person WHERE Person_ID = ?");
$stmt->execute([$userId]);
$person = $stmt->fetch();
if (!$person) {
    echo "User not found.";
    exit;
}

// Fetch "Your Ratings" – books the user has rated
$stmt = $pdo->prepare("SELECT b.*, r.Rating FROM rating r JOIN book b ON r.Book_ID = b.Book_ID WHERE r.Person_ID = ?
ORDER BY r.rating_id DESC");
$stmt->execute([$userId]);
$yourRatings = $stmt->fetchAll();

// Fetch wishlist items (join Wishlist with Book)
$stmt = $pdo->prepare("SELECT b.* FROM wishlist w JOIN book b ON w.Book_ID = b.Book_ID WHERE w.Person_ID = ?
ORDER BY w.wishlist_id DESC");
$stmt->execute([$userId]);
$wishlist = $stmt->fetchAll();
// After fetching wishlist items
$userWishlist = array_column($wishlist, 'Book_ID');

// Fetch ratings given by user
// Retrieve user ratings (if any)
$userRatings = [];
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT Book_ID, Rating FROM rating WHERE Person_ID = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $userRatings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}


// Fetch reviews posted by the user (join Review with Book for title)
$stmt = $pdo->prepare("
    SELECT r.*, b.Title AS book_title, COALESCE(rt.Rating, 'Not Rated') AS Rating
    FROM review r
    JOIN book b ON r.Book_ID = b.Book_ID
    LEFT JOIN rating rt ON r.Book_ID = rt.Book_ID AND r.Person_ID = rt.Person_ID
    WHERE r.Person_ID = ?
    ORDER BY r.Review_Date DESC
");
$stmt->execute([$userId]);
$reviews = $stmt->fetchAll();

include '../../templates/user/profile.php';
?>