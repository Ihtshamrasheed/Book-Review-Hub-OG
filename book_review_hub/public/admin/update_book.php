<?php
session_start();
require '../../src/config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: ../index.php");
    exit();
}

$activePage = 'books';

if (!isset($_GET['id'])) {
    header("Location: books.php");
    exit();
}

$bookId = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM book WHERE Book_ID = ?");
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
      $targetDir = "../img/";
      $filename = basename($_FILES["cover_image"]["name"]);
      $targetFilePath = $targetDir . $filename;
      move_uploaded_file($_FILES["cover_image"]["tmp_name"], $targetFilePath);
      $coverImagePath = 'img/' . $filename;
  } elseif (!empty($_POST['cover_url'])) {
      $coverImagePath = trim($_POST['cover_url']);
  }

  // Update Book table (for backwards compatibility)
  $genreString = implode(', ', $selectedGenres);
  $stmt = $pdo->prepare("UPDATE book SET Title = ?, Author = ?, Description = ?, Genre = ?, Cover_Image = ? WHERE Book_ID = ?");
  $stmt->execute([$title, $author, $description, $genreString, $coverImagePath, $bookId]);

  // Update book_genres table
  $pdo->prepare("DELETE FROM book_genres WHERE Book_ID = ?")->execute([$bookId]);

  // Map genre names to Genre_IDs and insert
  foreach ($selectedGenres as $genreName) {
      $genreStmt = $pdo->prepare("SELECT Genre_ID FROM genre WHERE Genre_Name = ?");
      $genreStmt->execute([$genreName]);
      $genreRow = $genreStmt->fetch();

      if ($genreRow) {
          $genreId = $genreRow['Genre_ID'];
          $insertStmt = $pdo->prepare("INSERT INTO book_genres (Book_ID, Genre_ID) VALUES (?, ?)");
          $insertStmt->execute([$bookId, $genreId]);
      }
  }

  header("Location: books.php");
  exit();
}



$currentGenres = array_map('trim', explode(',', $book['Genre']));

include '../../templates/admin/update_book.php';
?>