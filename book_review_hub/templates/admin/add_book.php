<!DOCTYPE html>
<html>
<head>
    <title>Add a Book - Admin Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="../../public/css/sidebar.css">
  <link rel="stylesheet" href="../../public/css/styles.css">
  <link rel="stylesheet" href="../../public/css/genre.css">



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
    <?php include '../../src/includes/admin_sidebar.php'; ?>
    <div class="container">
        <div class="content">
            <h2>Add a Book</h2>
            <form action="add_book.php" method="POST" enctype="multipart/form-data">

                    <div class="form-container">
  <div class="left-column">
    <!-- Cover Image Upload -->
    <!-- Genre Selection Dropdown -->
<!-- Select Genre Button -->
<button type="button" id="openGenreModal" class="btn btn-primary">Select Genre</button>
<div id="selectedGenres" class="mt-2"></div>

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
        "History", "Home/Garden", "Horror", "Humor", "Instructional","Juvenile","Action", "Juvenile", "Language",
        "Literary Classics", "Math/Science/Tech", "Medical", "Mystery", "Nature", "Philosophy",
        "Pol/Soc/Relig", "Recreation", "Romance", "Science Fiction", "Self-Help",
        "Travel/Adventure", "True Crime", "Urban Fantasy", "Western"
      ];
      foreach ($genres as $genre) {
          echo '<label><input type="checkbox" class="genre-checkbox" value="' . $genre . '"> ' . $genre . '</label><br>';
      }
      ?>
    </div>
  </div>
</div>

<!-- Hidden input to store genres (to be submitted with form) -->
<input type="hidden" name="genre" id="genreInput">
<br>
<label>Book Cover</label><br>

                        <div class="cover-dropzone" id="coverDropzone">
                            Click to choose
                            <input type="file" name="cover_image" accept="image/*">
                        <input type="text" name="cover_url" placeholder="Or Paste URL here" class="url-input">
                    </div>
                    </div>


  <div class="right-column">
    <!-- Title Input -->
    <!-- Author Input -->
    <!-- Description Textarea -->

                        <label>Title of the Book</label>
                        <input type="text" name="title" required>

                        <label>Name of the Author</label>
                        <input type="text" name="author" required>

                        <label>Description of the Book</label>
                        <textarea name="description" rows="6" required></textarea>
                          </div>


                    </div>
                <div class="form-actions" style="text-align: right; margin-top: 20px;">
                    <a href="books.php" class="btn cancel-btn">Cancel</a>
                    <button type="submit" class="btn submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
  <script src="../../public/js/drop.js"></script>

</body>
</html>