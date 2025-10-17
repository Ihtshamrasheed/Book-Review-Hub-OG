<?php
session_start();
require '../../src/config.php';
require '../../src/functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: ../index.php");
    exit();
}

$activePage = 'books';

$filters = [
    'search' => $_GET['search'] ?? '',
    'genres' => $_GET['genres'] ?? [],
    'sort' => $_GET['sort'] ?? 'Title_asc',
];

$books = getBooks($pdo, $filters);
$totalBooks = count($books);
$searchTerm = $filters['search'];
$selectedGenres = $filters['genres'];
$sortKey = $filters['sort'];

include '../../templates/admin/books.php';
?>