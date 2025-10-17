<?php
session_start();
require '../../src/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: ../index.php");
    exit();
}

$activePage = 'reviews';

// Default sort
$sortField = 'r.Review_Date';
$sortDir = 'DESC';

// Whitelisted fields
$validSortFields = [
    'book' => 'b.Title',
    'reviewer' => 'u.Username',
    'title' => 'r.Title',
    'content' => 'r.Content',
    'spoilers' => 'r.Contains_Spoilers',
    'date' => 'r.Review_Date'
];

$currentSort = $_GET['sort'] ?? '';
$currentDir = $_GET['dir'] ?? 'desc';

if (isset($validSortFields[$currentSort])) {
    $sortField = $validSortFields[$currentSort];
}

if (in_array(strtoupper($currentDir), ['ASC', 'DESC'])) {
    $sortDir = strtoupper($currentDir);
}

$search = $_GET['search'] ?? '';
$searchSql = '';
$params = [];

if (!empty($search)) {
    $searchSql = "AND (
        b.Title LIKE ? OR
        u.Username LIKE ? OR
        r.Title LIKE ? OR
        r.Content LIKE ?
    )";
    $wildSearch = "%$search%";
    $params = [$wildSearch, $wildSearch, $wildSearch, $wildSearch];
}


$sql = "SELECT r.Book_ID, r.Person_ID, r.Review_Date, r.Title, r.Content,
               r.Contains_Spoilers, r.InDltProcess,
               b.Title AS book_title, u.Username AS reviewer
        FROM review r
        JOIN book b ON r.Book_ID = b.Book_ID
        JOIN person u ON r.Person_ID = u.Person_ID
        WHERE r.InDltProcess = 0 $searchSql
        ORDER BY $sortField $sortDir";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$result = $stmt;
$totalReviews = $pdo->query("SELECT COUNT(*) FROM review")->fetchColumn();

// Sort link generator
function sortLink($label, $field, $currentSort, $currentDir) {
    $dir = ($currentSort === $field && strtolower($currentDir) === 'asc') ? 'desc' : 'asc';
    $arrow = '';
    if ($currentSort === $field) {
        $arrow = $currentDir === 'asc' ? ' ↑' : ' ↓';
    }
    $searchParam = isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '';
    return "<a href=\"?sort=$field&dir=$dir$searchParam\">$label$arrow</a>";
}

include '../../templates/admin/reviews.php';
?>