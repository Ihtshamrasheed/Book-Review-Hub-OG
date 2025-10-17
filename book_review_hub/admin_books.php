<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: index.php");
    exit();
}

$activePage = 'books';
include 'admin_header.php';
include 'admin_sidebar.php';

$searchTerm = $_GET['search'] ?? '';
$selectedGenres = $_GET['genres'] ?? [];
$sort = $_GET['sort'] ?? 'Title';

$query = "SELECT * FROM Book";
$conditions = [];
$params = [];

if ($searchTerm !== '') {
    $conditions[] = "(Title LIKE :title OR Author LIKE :author OR Description LIKE :description)";
    $params['title'] = "%$searchTerm%";
    $params['author'] = "%$searchTerm%";
    $params['description'] = "%$searchTerm%";
}

if (!empty($selectedGenres)) {
    $genreConditions = [];
    foreach ($selectedGenres as $genre) {
        $genreConditions[] = "Genre LIKE ?";
        $params[] = "%$genre%";
    }
    $conditions[] = '(' . implode(' OR ', $genreConditions) . ')';
}


if (!empty($conditions)) {
    $query .= " WHERE " . implode(' AND ', $conditions);
}

$sortOptions = [
    'Title_asc' => 'Title ASC',
    'Title_desc' => 'Title DESC',
    'Author_asc' => 'Author ASC',
    'Author_desc' => 'Author DESC',
    'Genre_asc' => 'Genre ASC',
    'Genre_desc' => 'Genre DESC',
    'Book_ID_asc' => 'Book_ID ASC',
    'Book_ID_desc' => 'Book_ID DESC',
    'Rating_asc' => 'Curr_rating ASC',
    'Rating_desc' => 'Curr_rating DESC'
];

$sortKey = $_GET['sort'] ?? 'Title_asc';
$orderClause = $sortOptions[$sortKey] ?? 'Title ASC';

$query .= " ORDER BY $orderClause";


$stmt = $pdo->prepare($query);
$stmt->execute(array_values($params));
$books = $stmt->fetchAll();

$totalBooks = count($books);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - All Books</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/sidebar.css">


  <style>
    body { display: flex; min-height: 100vh; }
    
    .content {
        padding-top: 80px;
        padding: 20px;
        flex-grow: 1;
    }
    .book-tile {
        border: 1px solid #ccc;
        padding: 10px;
        position: relative;
        border-radius: 6px;
        background: #f9f9f9;
        margin-bottom: 20px;
    }
    .book-cover {
        width: 100%;
        height: 250px;
        background-size: cover;
        background-position: center;
        border-radius: 5px;
    }
    .options-btn {
        position: absolute;
        top: 8px;
        right: 8px;
        cursor: pointer;
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 2px 8px;
    }
    .options-menu {
        display: none;
        position: absolute;
        right: 8px;
        top: 30px;
        background: white;
        border: 1px solid #ccc;
        border-radius: 4px;
        z-index: 10;
    }
    .options-menu a {
        display: block;
        padding: 5px 10px;
        text-decoration: none;
        color: black;
    }
    .options-menu a:hover {
        background: #f0f0f0;
    }
    .genreb {
      margin-top: -17px;
    }
    #genreModal {
  box-shadow: 0 0 15px rgba(0,0,0,0.3);
  max-height: 200vh;
  overflow-y: auto;
}

  .genre-checkboxes {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 5px 20px;
    max-height: 500px;
    overflow-y: auto;
  }




  </style>
</head>
<body>



<div class="container content mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manage Books (<?= $totalBooks; ?>)</h2>
    <form class="form-inline" method="get" action="" style="margin-left: auto;">
  <input type="text" name="search" class="form-control mr-2 "style="margin-top: 18px;" placeholder="Search books..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
</form>

    <a href="admin_add_book.php" class="btn btn-primary ">Add a Book</a>

    

  </div>
<div class="d-flex align-items-center mb-3">
  <button class="btn btn-outline-secondary mr-2 genreb" onclick="document.getElementById('genreModal').style.display='block'">Select Genre</button>

  <form method="get" class="form-inline">
    <input type="hidden" name="search" value="<?= htmlspecialchars($searchTerm) ?>">
    <?php foreach ((array)$selectedGenres as $genre): ?>
      <input type="hidden" name="genres[]" value="<?= htmlspecialchars($genre) ?>">
    <?php endforeach; ?>
    <select class="form-control " name="sort" onchange="this.form.submit()">
  <option value="Title_asc" <?= $sortKey == 'Title_asc' ? 'selected' : '' ?>>Title (A-Z)</option>
  <option value="Title_desc" <?= $sortKey == 'Title_desc' ? 'selected' : '' ?>>Title (Z-A)</option>
  <option value="Author_asc" <?= $sortKey == 'Author_asc' ? 'selected' : '' ?>>Author (A-Z)</option>
  <option value="Author_desc" <?= $sortKey == 'Author_desc' ? 'selected' : '' ?>>Author (Z-A)</option>
  <option value="Genre_asc" <?= $sortKey == 'Genre_asc' ? 'selected' : '' ?>>Genre (A-Z)</option>
  <option value="Genre_desc" <?= $sortKey == 'Genre_desc' ? 'selected' : '' ?>>Genre (Z-A)</option>
  <option value="Book_ID_asc" <?= $sortKey == 'Book_ID_asc' ? 'selected' : '' ?>>Upload (Asc)</option>
  <option value="Book_ID_desc" <?= $sortKey == 'Book_ID_desc' ? 'selected' : '' ?>>Upload (Desc)</option>
  <option value="Rating_asc" <?= $sortKey == 'Rating_asc' ? 'selected' : '' ?>>Rating (Low to High)</option>
  <option value="Rating_desc" <?= $sortKey == 'Rating_desc' ? 'selected' : '' ?>>Rating (High to Low)</option>
</select>

  </form>
</div>
  <div class="row">
    <?php foreach($books as $book): ?>
      <div class="col-md-3">
        <div class="book-tile">
          <div class="book-cover" style="background-image: url('<?= htmlspecialchars($book['Cover_Image']) ?>');"></div>
          <div class="mt-2 font-weight-bold"><?= htmlspecialchars($book['Title']) ?></div>
          <div class="text-muted">by <?= htmlspecialchars($book['Author']) ?></div>

          <div class="options-btn" onclick="toggleOptions(this)">⋮</div>
          <div class="options-menu">
            <a href="admin_update_book.php?id=<?= $book['Book_ID'] ?>">Update Book</a>
            <a href="admin_delete_book.php?id=<?= $book['Book_ID'] ?>" onclick="return confirm('Are you sure?')">Delete Book</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
 <div id="genreModal" style="display:none; position:fixed; top:10%; left:30%; width:40%; background:#fff; padding:20px; border:1px solid #ccc; border-radius:10px; z-index:999;">
  <h5>Select Genres</h5>
  <form id="genreForm" method="get">
    <input type="hidden" name="search" value="<?= htmlspecialchars($searchTerm) ?>">
    <input type="hidden" name="sort" value="<?= htmlspecialchars($sortKey) ?>">

    <div class="genre-checkboxes" style="max-height: 300px; overflow-y: auto;">
      <?php
      $genres = [
        "Adventure", "Art", "Biographical", "Business", "Computer/Internet", "Crafts",
        "Crime/Thriller", "Fantasy", "Food", "Fiction", "Non-Fiction", "Historical Fiction",
        "History", "Home/Garden", "Horror", "Humor", "Instructional", "Juvenile", "Action", "Language",
        "Literary Classics", "Math/Science/Tech", "Medical", "Mystery", "Nature", "Philosophy",
        "Pol/Soc/Relig", "Recreation", "Romance", "Science Fiction", "Self-Help",
        "Travel/Adventure", "True Crime", "Urban Fantasy", "Western"
      ];
        foreach ($genres as $genre) {
    $checked = in_array($genre, $selectedGenres ?? []) ? 'checked' : '';
    echo '<label><input type="checkbox" class="genre-checkbox" name="genres[]" value="' . $genre . '" ' . $checked . '> ' . $genre . '</label>';
  }
      ?>
    </div>

    <div class="mt-3 d-flex justify-content-between">
      <button type="submit" class="btn btn-success">Done</button>
      <button type="button" class="btn btn-secondary" onclick="document.getElementById('genreModal').style.display='none'">Cancel</button>
    </div>
  </form>
</div>


</div>

<script>
  function toggleOptions(btn) {
    const menu = btn.nextElementSibling;
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    // Close others
    document.querySelectorAll('.options-menu').forEach(m => {
      if (m !== menu) m.style.display = 'none';
    });
  }
  document.addEventListener('click', function(e) {
    if (!e.target.matches('.options-btn')) {
      document.querySelectorAll('.options-menu').forEach(m => m.style.display = 'none');
    }
  });
</script>

</body>
</html>
