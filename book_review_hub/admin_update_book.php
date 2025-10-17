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

if (!isset($_GET['id'])) {
    header("Location: admin_books.php");
    exit();
}

$bookId = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM Book WHERE Book_ID = ?");
$stmt->execute([$bookId]);
$book = $stmt->fetch();

if (!$book) {
    echo "Book not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = trim($_POST['title']);
  $author = trim($_POST['author']);
  $description = trim($_POST['description']);
  $selectedGenres = isset($_POST['genre']) ? explode(', ', trim($_POST['genre'])) : [];
  $coverImagePath = $book['Cover_Image'];

  // Handle cover image upload
  if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
      $targetDir = "img/";
      $filename = basename($_FILES["cover_image"]["name"]);
      $targetFilePath = $targetDir . $filename;
      move_uploaded_file($_FILES["cover_image"]["tmp_name"], $targetFilePath);
      $coverImagePath = 'img/' . $filename;
  } elseif (!empty($_POST['cover_url'])) {
      $coverImagePath = trim($_POST['cover_url']);
  }

  // Update Book table (for backwards compatibility)
  $genreString = implode(', ', $selectedGenres);
  $stmt = $pdo->prepare("UPDATE Book SET Title = ?, Author = ?, Description = ?, Genre = ?, Cover_Image = ? WHERE Book_ID = ?");
  $stmt->execute([$title, $author, $description, $genreString, $coverImagePath, $bookId]);

  // Update book_genres table
  $pdo->prepare("DELETE FROM book_genres WHERE Book_ID = ?")->execute([$bookId]);

  // Map genre names to Genre_IDs and insert
  foreach ($selectedGenres as $genreName) {
      $genreStmt = $pdo->prepare("SELECT Genre_ID FROM Genre WHERE Genre_Name = ?");
      $genreStmt->execute([$genreName]);
      $genreRow = $genreStmt->fetch();

      if ($genreRow) {
          $genreId = $genreRow['Genre_ID'];
          $insertStmt = $pdo->prepare("INSERT INTO book_genres (Book_ID, Genre_ID) VALUES (?, ?)");
          $insertStmt->execute([$bookId, $genreId]);
      }
  }

  header("Location: admin_books.php");
  exit();
}



$currentGenres = array_map('trim', explode(',', $book['Genre']));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Book - Admin Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/sidebar.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/genre.css">



    <style>
  body { display: flex; min-height: 100vh; }
  
  .content {
      padding-top: 80px;
      padding: 20px;
      flex-grow: 1;
  }
  </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <h2>Update Book</h2>
            <form action="admin_update_book.php?id=<?= $bookId ?>" method="POST" enctype="multipart/form-data">
                <div class="form-container">
  <div class="left-column">
    <!-- Cover Image Upload -->
    <!-- Genre Selection Dropdown -->
                    
                        <!-- Select Genre Button -->
<button type="button" id="openGenreModal" class="btn btn-primary">Select Genre</button>
<div id="selectedGenres" class="mt-2">
  <?php foreach ($currentGenres as $genre): ?>
    <span class="selected-genre"><?= htmlspecialchars($genre) ?></span>
  <?php endforeach; ?>
</div>

<!-- Genre Modal -->
<div id="genreModal" class="genre-modal">
  <div class="genre-modal-content">
    <div class="genre-modal-header">
      <h4>Select Genres</h4>
      <button type="button" id="closeGenreModal" class="btn btn-success">Done</button>
    </div>
    <div class="genre-checkboxes">
      <!-- Generate checkbox list -->
      <?php
      $genres = [
        "Adventure", "Art", "Biographical", "Business", "Computer/Internet", "Crafts",
        "Crime/Thriller", "Fantasy", "Food", "Fiction", "Non-Fiction", "Historical Fiction",
        "History", "Home/Garden", "Horror", "Humor", "Instructional",  "Juvenile","Action", "Language",
        "Literary Classics", "Math/Science/Tech", "Medical", "Mystery", "Nature", "Philosophy",
        "Pol/Soc/Relig", "Recreation", "Romance", "Science Fiction", "Self-Help",
        "Travel/Adventure", "True Crime", "Urban Fantasy", "Western"
      ];
      foreach ($genres as $genre) {
    $isChecked = in_array($genre, $currentGenres) ? 'checked' : '';
    echo '<label><input type="checkbox" class="genre-checkbox" value="' . $genre . '" ' . $isChecked . '> ' . $genre . '</label><br>';
}

      ?>
    </div>
  </div>
</div>

<!-- Hidden input to store genres (to be submitted with form) -->
<input type="hidden" name="genre" id="genreInput">
<label>Book Cover</label><br><br>

                        <div class="cover-dropzone" id="coverDropzone">

                            <?php if (!empty($book['Cover_Image'])): ?>
                                <img src="<?= $book['Cover_Image'] ?>" width="100%">
                            <?php endif; ?>
                            <input type="file" name="cover_image" accept="image/*">
                        <input type="text" name="cover_url" placeholder="Or Paste URL here" class="url-input">
                        </div>

                         </div>
  <div class="right-column">
    <!-- Title Input -->
    <!-- Author Input -->
    <!-- Description Textarea -->
                    
                        <label>Title of the Book</label>
                        <input type="text" name="title" value="<?= htmlspecialchars($book['Title']) ?>" required>

                        <label>Name of the Author</label>
                        <input type="text" name="author" value="<?= htmlspecialchars($book['Author']) ?>" required>

                        <label>Description of the Book</label>
                        <textarea name="description" rows="6" required><?= htmlspecialchars($book['Description']) ?></textarea>
                     </div>
</div>
                
                <div class="form-actions" style="text-align: right; margin-top: 20px;">
                    <a href="admin_books.php" class="btn cancel-btn">Cancel</a>
                    <button type="submit" class="btn submit-btn">Update</button>
                </div>
            </form>
        </div>
    </div>

  <script src="js/drop.js"></script>
    
</body>
</html>
