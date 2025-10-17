<?php
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: index.php");
    exit();
}


$activePage = 'users';
include 'admin_header.php';
include 'admin_sidebar.php';

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
$totalUsers = $pdo->query("SELECT COUNT(*) FROM Person WHERE Role = 0")->fetchColumn();

$users = $stmt->fetchAll();

?>

<head>
    <title>Admin -  Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <style>
        body { display: flex; min-height: 100vh; }
        .content { padding-top: 80px; padding: 20px; flex-grow: 1; }
        th a { color: inherit; text-decoration: none; }
        

    </style>
</head>

<?php
function sortLink($label, $field, $currentSort, $currentDir, $search) {
    $dir = ($currentSort === $field && strtolower($currentDir) === 'asc') ? 'desc' : 'asc';
    $arrow = '';
    if ($currentSort === $field) {
        $arrow = $currentDir === 'asc' ? ' ↑' : ' ↓';
    }
    $searchParam = $search ? '&search=' . urlencode($search) : '';
    return "<a href=\"?sort=$field&dir=$dir$searchParam\">$label$arrow</a>";
}
?>

<div class="container content mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Manage Users (<?= $totalUsers; ?>)</h2>
        <form method="GET" class="form-inline">
            <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
            <input type="hidden" name="dir" value="<?= htmlspecialchars($dir) ?>">
            <input type="text" name="search" class="form-control form-control-sm mr-2" placeholder="Search username/email" value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-sm btn-primary">Search</button>
        </form>
    </div>

    <table class="table table-striped">
        <thead>
            <tr class="text-center">
                <th><?= sortLink('ID', 'id', $sort, $dir, $search) ?></th>
                <th><?= sortLink('Username', 'username', $sort, $dir, $search) ?></th>
                <th><?= sortLink('Email', 'email', $sort, $dir, $search) ?></th>
                <th><?= sortLink('Role', 'role', $sort, $dir, $search) ?></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php if (count($users) === 0): ?>
        <tr><td colspan="5" class="text-center">No users found.</td></tr>
    <?php else: ?>
        <?php foreach($users as $user): ?>
            <tr class="text-center">
                <td><?= htmlspecialchars($user['Person_id']) ?></td>
                <td><?= htmlspecialchars($user['Username']) ?></td>
                <td><?= htmlspecialchars($user['Email']) ?></td>
                <td><?= $user['Role'] == 1 ? 'Admin' : 'User' ?></td>
                <td>
                    <a href="toggle_role.php?id=<?= $user['Person_id'] ?>" 
   class="btn btn-sm btn-secondary"
   onclick="return confirm('Are you sure you want to change this user\'s role?');">
   <?= $user['Role'] == 1 ? 'Make User' : 'Make Admin' ?>
</a>

                    <a href="admin_edit_user.php?id=<?= $user['Person_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete_user.php?id=<?= $user['Person_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    
                    </a>
                    
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</tbody>

    </table>
</div>
