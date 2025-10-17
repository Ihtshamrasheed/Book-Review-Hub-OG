<head>
    <title>Admin - Reviews</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/sidebar.css">
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

<?php include '../../src/includes/admin_sidebar.php'; ?>

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

                        <a onclick="return confirm('Are you sure you want to delete this Review?');" href="delete_review.php?book_id=<?= $review['Book_ID'] ?>&person_id=<?= $review['Person_ID'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>