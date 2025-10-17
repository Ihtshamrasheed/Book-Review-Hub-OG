<?php
include 'config.php'; // Database connection

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: index.php");
    exit();
}


$activePage = 'reviews';

include 'admin_header.php';
include 'admin_sidebar.php';

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
 //   'status' => 'r.InDltProcess',
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
$totalReviews = $pdo->query("SELECT COUNT(*) FROM Review")->fetchColumn();

?>

<head>
    <title>Admin - Reviews</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <style>
        body { display: flex; min-height: 100vh; }
        .content { padding-top: 80px; padding: 20px; flex-grow: 1; }
        td, th { vertical-align: middle; }
        .clickable-row { cursor: pointer; }
        .expanded { white-space: normal !important; }

        a {
            color: #000;
        }
td .full-content, td .short-content {
    display: block;
    white-space: pre-wrap;
    word-wrap: break-word;
}

    </style>
    <script>
    function toggleExpand(row) {
        const short = row.querySelector('.short-content');
        const full = row.querySelector('.full-content');
        if (short && full) {
            short.classList.toggle('d-none');
            full.classList.toggle('d-none');
        }
        row.classList.toggle('expanded');
    }
</script>

</head>

<?php
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

?>

<div class="container content mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manage Reviews (<?= $totalReviews; ?>)</h2>
    <form method="GET" class="form-inline">
        <input type="hidden" name="sort" value="<?= htmlspecialchars($currentSort) ?>">
        <input type="hidden" name="dir" value="<?= htmlspecialchars($currentDir) ?>">
        <input type="text" name="search" class="form-control form-control-sm mr-2" placeholder="Search book/reviewer/title/comment" value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-sm btn-primary">Search</button>
    </form>
</div>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th><?= sortLink('Book', 'book', $currentSort, $currentDir) ?></th>
                <th><?= sortLink('Reviewer', 'reviewer', $currentSort, $currentDir) ?></th>
                <th><?= sortLink('Review Title', 'title', $currentSort, $currentDir) ?></th>
                <th><?= sortLink('Comment', 'content', $currentSort, $currentDir) ?></th>
                <th><?= sortLink('Spoilers', 'spoilers', $currentSort, $currentDir) ?></th>
                <!--<th>Status</th> -->
                <th><?= sortLink('Submitted On', 'date', $currentSort, $currentDir) ?></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($review = $result->fetch()): ?>
                <tr class="clickable-row" onclick="toggleExpand(this)">
                    <td style = "width: 210px;"><?= htmlspecialchars($review['book_title']) ?></td>
                    <td  style = "width: 110px;">><?= htmlspecialchars($review['reviewer']) ?></td>
                    <td style = "width: 180px;"> <?= htmlspecialchars($review['Title']) ?></td>
                    <td>
    <span class="short-content" style = "width: 200px;"><?= htmlspecialchars(mb_substr($review['Content'], 0, 50)) ?><?= mb_strlen($review['Content']) > 47 ? '...' : '' ?></span>
    <span class="full-content d-none" style = "width: 200px;"><?= nl2br(htmlspecialchars($review['Content'])) ?></span>
</td>

                    <td style = "width: 99px;"><?= $review['Contains_Spoilers'] ? 'Yes' : 'No' ?></td>
                    <!--<td><?= $review['InDltProcess'] ? 'Pending Deletion' : 'Active' ?></td>-->
                    <td style = "width: 150px;"><?= htmlspecialchars($review['Review_Date']) ?></td>
                    <td>

                        <a onclick="return confirm('Are you sure you want to delete this Review?');" href="admin_delete_review.php?book_id=<?= $review['Book_ID'] ?>&person_id=<?= $review['Person_ID'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
