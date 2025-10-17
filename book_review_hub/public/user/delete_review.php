<?php
session_start();
require '../../src/config.php';

// Ensure the id parameter is provided (format: PersonID_BookID)
if (!isset($_GET['id'])) {
    header("Location: home.php");
    exit;
}

// Split the composite id (e.g., "1_5") into Person_ID and Book_ID
list($personId, $bookId) = explode('_', $_GET['id']);

// Ensure the logged-in user is the owner of the review
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $personId) {
    echo "Unauthorized access.";
    exit;
}

// Delete the review from the Review table
$stmt = $pdo->prepare("DELETE FROM review WHERE Person_ID = ? AND Book_ID = ?");
$stmt->execute([$personId, $bookId]);

// Optionally, if you want to delete the rating as well, uncomment the following lines:
// $stmt = $pdo->prepare("DELETE FROM Rating WHERE Person_ID = ? AND Book_ID = ?");
// $stmt->execute([$personId, $bookId]);

// Determine where to redirect the user after deletion
if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
    $redirectUrl = $_GET['redirect'];
} elseif (isset($_SERVER['HTTP_REFERER'])) {
    $redirectUrl = $_SERVER['HTTP_REFERER'];
} else {
    $redirectUrl = 'home.php';
}

// Redirect user to the appropriate page
header("Location: " . $redirectUrl);
exit;
?>