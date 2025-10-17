<?php
session_start();
require '../../src/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: ../index.php");
    exit();
}
$activePage = 'books';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $description = trim($_POST['description']);
    $selectedGenres = isset($_POST['genre']) ? explode(', ', trim($_POST['genre'])) : [];

    $coverImagePath = '';

    // Handle image upload
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
        $targetDir = "img/";
        $filename = basename($_FILES["cover_image"]["name"]);
        $targetFilePath = $targetDir . $filename;
        move_uploaded_file($_FILES["cover_image"]["tmp_name"], $targetFilePath);
        $coverImagePath = 'img/' . $filename;
    } elseif (!empty($_POST['cover_url'])) {
        $coverImagePath = trim($_POST['cover_url']);
    }

    // Insert book first (without Genre) to get Book_ID
    $stmt = $pdo->prepare("INSERT INTO book (Title, Author, Description, Genre, Cover_Image) VALUES (?, ?, ?, '', ?)");
    $stmt->execute([$title, $author, $description, $coverImagePath]);
    $bookId = $pdo->lastInsertId(); // Get the newly inserted Book_ID

    // Insert selected genres into Genre table
    // Insert selected genres into book_genres table by mapping to Genre_ID
foreach ($selectedGenres as $genreName) {
  // Trim and normalize genre name
  $genreName = trim($genreName);

  // Get Genre_ID from genre table
  $stmt = $pdo->prepare("SELECT Genre_ID FROM genre WHERE LOWER(Genre_Name) = LOWER(?)");
  $stmt->execute([$genreName]);
  $genreRow = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($genreRow) {
      $genreId = $genreRow['Genre_ID'];

      // Insert into book_genres (avoid duplicates)
      $stmtInsert = $pdo->prepare("INSERT IGNORE INTO book_genres (Book_ID, Genre_ID) VALUES (?, ?)");
      $stmtInsert->execute([$bookId, $genreId]);
  }
}


    // Optionally update genre string in book table if needed
    $genreString = implode(', ', $selectedGenres);
    $stmt = $pdo->prepare("UPDATE book SET Genre = ? WHERE Book_ID = ?");
    $stmt->execute([$genreString, $bookId]);

    header("Location: books.php");
    exit();
}

include '../../templates/admin/add_book.php';
?>