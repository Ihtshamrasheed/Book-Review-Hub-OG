<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require '../../src/config.php';
require '../../src/functions.php';

$filters = [
    'search' => $_GET['search'] ?? '',
    'genres' => $_GET['genres'] ?? [],
    'sort' => $_GET['sort'] ?? 'Title_asc',
];

$books = getBooks($pdo, $filters);

$userRatings = [];
$userWishlist = [];

foreach ($books as $book) {
    if ($book['user_rating']) {
        $userRatings[$book['Book_ID']] = $book['user_rating'];
    }
    if ($book['in_wishlist']) {
        $userWishlist[] = $book['Book_ID'];
    }
}

$searchTerm = $filters['search'];
$selectedGenres = $filters['genres'];
$sortKey = $filters['sort'];

include '../../templates/user/home.php';
?>