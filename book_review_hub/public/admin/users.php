<?php
session_start();
require '../../src/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: ../index.php");
    exit();
}

$activePage = 'users';

// Handle sorting
$validSortFields = [
    'id' => 'Person_id',
    'username' => 'Username',
    'email' => 'Email',
    'role' => 'Role'
];

$sort = $_GET['sort'] ?? 'id';
$dir = $_GET['dir'] ?? 'desc';
$sortField = $validSortFields[$sort] ?? 'Person_id';
$sortDir = strtoupper($dir) === 'ASC' ? 'ASC' : 'DESC';

// Handle search
$search = $_GET['search'] ?? '';
$params = [];
$searchSql = '';

if (!empty($search)) {
    $searchSql = "WHERE Username LIKE ? OR Email LIKE ?";
    $params = ["%$search%", "%$search%"];
}

$sql = "SELECT Person_id, Username, Email, Role FROM person $searchSql ORDER BY $sortField $sortDir";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$totalUsers = $pdo->query("SELECT COUNT(*) FROM person WHERE Role = 0")->fetchColumn();

$users = $stmt->fetchAll();

function sortLink($label, $field, $currentSort, $currentDir, $search) {
    $dir = ($currentSort === $field && strtolower($currentDir) === 'asc') ? 'desc' : 'asc';
    $arrow = '';
    if ($currentSort === $field) {
        $arrow = $currentDir === 'asc' ? ' ↑' : ' ↓';
    }
    $searchParam = $search ? '&search=' . urlencode($search) : '';
    return "<a href=\"?sort=$field&dir=$dir$searchParam\">$label$arrow</a>";
}

include '../../templates/admin/users.php';
?>