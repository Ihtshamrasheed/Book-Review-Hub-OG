
<?php
session_start();
require 'config.php';

$response = ['success' => false];

if (isset($_SESSION['user_id'], $_POST['book_id'])) {
    $stmt = $pdo->prepare("SELECT Rating FROM Rating WHERE Book_ID = ? AND Person_ID = ?");
    $stmt->execute([$_POST['book_id'], $_SESSION['user_id']]);
    $rating = $stmt->fetchColumn();

    if ($rating !== false) {
        $response['success'] = true;
        $response['rating'] = (int)$rating;
    }
}

echo json_encode($response);
