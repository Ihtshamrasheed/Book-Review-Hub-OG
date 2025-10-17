<?php
session_start();
require 'config.php';

// Retrieve user ratings (if any)
$userRatings = [];
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT Book_ID, Rating FROM Rating WHERE Person_ID = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $userRatings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}

// Fetch all books
$query = "SELECT * FROM Book";
$conditions = [];
$params = [];

$searchTerm = $_GET['search'] ?? '';
$selectedGenres = $_GET['genres'] ?? [];
$sortKey = $_GET['sort'] ?? 'Title_asc';

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
    'Book_ID_asc' => 'Book_ID ASC',
    'Book_ID_desc' => 'Book_ID DESC',
    'Rating_asc' => 'Curr_rating ASC',
    'Rating_desc' => 'Curr_rating DESC'
];

$orderClause = $sortOptions[$sortKey] ?? 'Title ASC';
$query .= " ORDER BY $orderClause";
?>
<script> console.log(<?php $query?>)</script>
<?php $stmt = $pdo->prepare($query);
$stmt->execute(array_values($params));
$books = $stmt->fetchAll();




// Retrieve user's wishlist so hearts are pre-highlighted
$userWishlist = [];
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT Book_ID FROM Wishlist WHERE Person_ID = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $userWishlist = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Home - Review Hub</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/user_home.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/header.css">
 <style>
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
  <!-- Header -->
  <?php include 'header.php'; ?>
  
  <div class="container mt-4">

<div class="d-flex  align-items-center mb-3">
<div >    
<h3 style=" margin-top: -20px;" >Books (<?= count($books); ?>)</h3>
</div>
<div class="d-flex align-items-center ml-4 mb-3">
    <button class="btn btn-outline-secondary mr-3 logout-btn"style=" margin-top: -15px;"  onclick="document.getElementById('genreModal').style.display='block'">Select Genre</button>

    <form method="get" class="form-inline">
        <input type="hidden" name="search" value="<?= htmlspecialchars($searchTerm) ?>">
        <?php foreach ($selectedGenres as $genre): ?>
            <input type="hidden" name="genres[]" value="<?= htmlspecialchars($genre) ?>">
        <?php endforeach; ?>
        <select class="form-control" name="sort" onchange="this.form.submit()">
            <option value="Title_asc" <?= $sortKey == 'Title_asc' ? 'selected' : '' ?>>Title (A-Z)</option>
            <option value="Title_desc" <?= $sortKey == 'Title_desc' ? 'selected' : '' ?>>Title (Z-A)</option>
            <option value="Author_asc" <?= $sortKey == 'Author_asc' ? 'selected' : '' ?>>Author (A-Z)</option>
            <option value="Author_desc" <?= $sortKey == 'Author_desc' ? 'selected' : '' ?>>Author (Z-A)</option>
            <option value="Book_ID_asc" <?= $sortKey == 'Book_ID_asc' ? 'selected' : '' ?>>Upload (ASC)</option>
            <option value="Book_ID_desc" <?= $sortKey == 'Book_ID_desc' ? 'selected' : '' ?>>Upload (DESC)</option>
            <option value="Rating_asc" <?= $sortKey == 'Rating_asc' ? 'selected' : '' ?>>Rating (Low to High)</option>
            <option value="Rating_desc" <?= $sortKey == 'Rating_desc' ? 'selected' : '' ?>>Rating (High to Low)</option>
        </select>
    </form>
</div>
    
</div>

<!-- Genre & Sort Controls -->

    <div style=" margin-top: -30px;" class="row">
      <?php foreach($books as $book): ?>
        <div class="col-md-3">
          <div class="book-tile">
            <a href="book_details.php?id=<?= $book['Book_ID'] ?>">
              <div class="book-cover" style="background-image: url('<?= htmlspecialchars($book['Cover_Image']) ?>');"></div>
              <div class="book-title">
                <?= htmlspecialchars($book['Title']) ?>
                <!-- Wishlist Heart Icon -->
                <div class="wishlist-heart" data-book-id="<?= $book['Book_ID'] ?>">
                  <?= (isset($userWishlist) && in_array($book['Book_ID'], $userWishlist)) ? '&#9829;' : '&#9825;'; ?>
                </div>
              </div>
              <div class="book-author">

  <!-- Author name -->
  by <?= htmlspecialchars($book['Author']) ?>

              <!-- Book average rating -->
  <div class="book-rating">
          <span style="cursor:pointer; color:#ffc107; font-size: 20px">&#9733;</span>
    <?= htmlspecialchars($book['Curr_Rating']) != NULL 
        ? number_format(htmlspecialchars($book['Curr_Rating']), 1) . "/10 (" . htmlspecialchars($book['Rating_User_Count']) . ")" 
        : "N/A"; ?>
  </div>

                <!-- Rate Button or Your Rating -->
                <?php if(isset($_SESSION['user_id']) && isset($userRatings[$book['Book_ID']])): ?>
                  <div class="your-rating" data-book-id="<?= $book['Book_ID'] ?>">
                    Your rating: <?= $userRatings[$book['Book_ID']] ?>/10
                  </div>
                <?php else: ?>
                  <div class="rate-btn " data-book-id="<?= $book['Book_ID'] ?>">Rate</div>
                <?php endif; ?>

              </div>
              
            </a>
          </div>
        </div>

      <?php endforeach; ?>
    </div>
  </div>
  
  <!-- Rate Modal -->
  <div id="rateModal" style="display:none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); z-index:1000; text-align: center;">
    <div style="background:#fff; padding:20px; width:80%; max-width:400px; margin:100px auto; border-radius:8px; position: relative;">
      <span id="closeRateModal" style="position:absolute; top:10px; right:10px; cursor:pointer; font-size:24px;">&times;</span>
      <h5>Rate this Book</h5>
      <div id="starContainer" style="font-size: 24px;">
        <?php for($i = 1; $i <= 10; $i++): ?>
          <span class="star" data-value="<?= $i; ?>" style="cursor:pointer; color:#ccc;">&#9733;</span>
        <?php endfor; ?>
      </div>
      <div style="display:flex; justify-content: center;">
      <h4 id="selectedRatingText" class="mt-2">0/10</h4>

      <button id="submitRating" class="btn btn-primary mt-2 ml-3 logout-btn">Done</button>
        </div>
    </div>
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
            <button type="submit " class="btn btn-success logout-btn">Done</button>
            <button type="button" class="btn btn-secondary logout-btn" onclick="document.getElementById('genreModal').style.display='none'">Cancel</button>
        </div>
    </form>
</div>

  <!-- jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="js/user_home.js"></script>
  <script >
// Reset stars when modal opens
function resetRatingModal() {
    selectedRating = 0;
    $('.star').css('color', '#ccc');
    $('#selectedRatingText').text('Rating: 0/10');
}

  
  // Wishlist toggle via AJAX
  $('.wishlist-heart').click(function(e){
    e.preventDefault();
    e.stopPropagation();
    var bookId = $(this).data('book-id');
    var heart = $(this);
    $.post('wishlist.php', { book_id: bookId }, function(response){
      if(response.status === 'added'){
        heart.html('&#9829;');
        heart.css('color', '000');
      } else if(response.status === 'removed'){
        heart.html('&#9825;');
        heart.css('color', '000'); // red outline
      }
    }, 'json');
  });
  
  // Rate Modal functionality: clicking rate or your rating opens modal
  var selectedRating = 0;
$('.rate-btn, .your-rating').click(function(e){
  e.preventDefault();
  e.stopPropagation();
  resetRatingModal();
  var bookId = $(this).data('book-id');
  $('#rateModal').data('book-id', bookId).fadeIn();

  // Fetch existing rating
  $.post('get_user_rating.php', { book_id: bookId }, function(response){
    if (response.success && response.rating > 0) {
      selectedRating = response.rating;
      $('#selectedRatingText').text('Rating: ' + selectedRating + '/10');
      $('.star').each(function(){
        $(this).css('color', ($(this).data('value') <= selectedRating) ? '#ffc107' : '#ccc');
      });
    }
  }, 'json');
});

  
  $('#closeRateModal').click(function(){
    $('#rateModal').fadeOut();
  });
  
  // Star rating hover and click functionality
  $('.star').hover(
    function(){
      var value = $(this).data('value');
      $('.star').each(function(){
        $(this).css('color', ($(this).data('value') <= value) ? '#ffc107' : '#ccc');
      });
    },
    function(){
      $('.star').each(function(){
        $(this).css('color', ($(this).data('value') <= selectedRating) ? '#ffc107' : '#ccc');
      });
    }
  );
  $('.star').click(function(){
  selectedRating = $(this).data('value');
  $('#selectedRatingText').text(selectedRating + '/10');
});

  
 $('#submitRating').click(function(){
  var bookId = $('#rateModal').data('book-id');
  if (selectedRating > 0) {
    $.post('submit_rating.php', { book_id: bookId, rating: selectedRating }, function(response){
      if (response.success) {
        location.reload();
      }
    }, 'json');
  }
});



  </script>
  
</body>
</html>