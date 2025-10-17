<?php
session_start();
require 'config.php';
$maxDisplay = 7;
$allDisplay = 100;



if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
$userId = $_SESSION['user_id'];

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM Person WHERE Person_ID = ?");
$stmt->execute([$userId]);
$person = $stmt->fetch();
if (!$person) {
    echo "User not found.";
    exit;
}

// Fetch "Your Ratings" – books the user has rated
$stmt = $pdo->prepare("SELECT b.*, r.Rating FROM Rating r JOIN Book b ON r.Book_ID = b.Book_ID WHERE r.Person_ID = ?
ORDER BY r.Rating_ID DESC");
$stmt->execute([$userId]);  
$yourRatings = $stmt->fetchAll();

// Fetch wishlist items (join Wishlist with Book)
$stmt = $pdo->prepare("SELECT b.* FROM Wishlist w JOIN Book b ON w.Book_ID = b.Book_ID WHERE w.Person_ID = ?
ORDER BY w.wishlist_id DESC");
$stmt->execute([$userId]);
$wishlist = $stmt->fetchAll();
// After fetching wishlist items
$userWishlist = array_column($wishlist, 'Book_ID');

// Fetch ratings given by user
// Retrieve user ratings (if any)
$userRatings = [];
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT Book_ID, Rating FROM Rating WHERE Person_ID = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $userRatings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}


// Fetch reviews posted by the user (join Review with Book for title)
$stmt = $pdo->prepare("
    SELECT r.*, b.Title AS book_title, COALESCE(rt.Rating, 'Not Rated') AS Rating 
    FROM Review r 
    JOIN Book b ON r.Book_ID = b.Book_ID 
    LEFT JOIN Rating rt ON r.Book_ID = rt.Book_ID AND r.Person_ID = rt.Person_ID 
    WHERE r.Person_ID = ? 
    ORDER BY r.Review_Date DESC
");
$stmt->execute([$userId]);
$reviews = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($person['Username']) ?>'s Profile - Review Hub</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/profile.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/header.css">


</head>
<body>
<?php include 'header.php'; ?>
  <div class="container mt-4">
    <!-- Profile Information (remains at top) -->
    <div class=" d-flex justify-content-between align-items-center ">
      <div class="profile-info pfd">
        <h2><?= htmlspecialchars($person['Username']) ?>'s Profile</h2>
        <p>Email: <?= htmlspecialchars($person['Email']) ?></p>
        <p>Joined: <?= date('M d, Y', strtotime($person['Join_Date'])) ?></p>
      </div>
      <a href="edit_user.php" class="logout-btn pfd">Edit Profile</a>
    </div>
    
    <!-- Your Ratings Section -->
    <div id="ratings-section">
<div class="profile-section">
  <h3 id="ratings-title">
  Your Ratings
</h3>

  <?php if(count($yourRatings) > 0): ?>
    <div class="row tile-row frating">
      <?php

foreach(array_slice($yourRatings, 0, $maxDisplay) as $ratedBook): ?>

        <div class="col-md-3">
          <div class="book-tile">
            <a href="book_details.php?id=<?= $ratedBook['Book_ID'] ?>">
              <div class="book-cover" style="background-image: url('<?= htmlspecialchars($ratedBook['Cover_Image']) ?>');"></div>
              <div class="book-title">
                <?= htmlspecialchars($ratedBook['Title']) ?>
                <div class="wishlist-heart" data-book-id="<?= $ratedBook['Book_ID'] ?>">
                  <?= in_array($ratedBook['Book_ID'], $userWishlist) ? '&#9829;' : '&#9825;'; ?>
                </div>
              </div>
              <div class="book-author">
                by <?= htmlspecialchars($ratedBook['Author']) ?>
               <?php if(isset($_SESSION['user_id']) && isset($userRatings[$ratedBook['Book_ID']])): ?>
                  <div class="your-rating" data-book-id="<?= $ratedBook['Book_ID'] ?>">
                    Your rating: <?= $userRatings[$ratedBook['Book_ID']] ?>/10
                  </div>
                <?php else: ?>
                  <div class="rate-btn " data-book-id="<?= $ratedBook['Book_ID'] ?>">Rate</div>
                <?php endif; ?>
              </div>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
      <?php if (count($yourRatings) > $maxDisplay): ?>
  <div class="col-md-3" id="viewAllRatings">
    <div class="book-tile text-center d-flex flex-column justify-content-center align-items-center"  style="height: 100%;">
      <button class="btn btn-primary mt-5 backbtn" >View All</button>
    </div>
  </div>
  
<?php endif; ?>


    </div>
  <?php else: ?>
    <p>You have not rated any books yet.</p>
  <?php endif; ?>
</div>
</div>
    
   <div id="alllratings">
<div class="profile-section">
  <h3 id="ratings-title">
  Your Ratings (<?= count($yourRatings); ?>)
  <button id="backFromRatings" class="btn btn-sm  btn-secondary backbtn float-right d-none">Back</button>
</h3>

  <?php if(count($yourRatings) > 0): ?>
    <div class="row tile-row frating">
      <?php

foreach(array_slice($yourRatings, 0, $allDisplay) as $ratedBook): ?>

        <div class="col-md-3">
          <div class="book-tile">
            <a href="book_details.php?id=<?= $ratedBook['Book_ID'] ?>">
              <div class="book-cover" style="background-image: url('<?= htmlspecialchars($ratedBook['Cover_Image']) ?>');"></div>
              <div class="book-title">
                <?= htmlspecialchars($ratedBook['Title']) ?>
                <div class="wishlist-heart" data-book-id="<?= $ratedBook['Book_ID'] ?>">
                  <?= in_array($ratedBook['Book_ID'], $userWishlist) ? '&#9829;' : '&#9825;'; ?>
                </div>
              </div>
              <div class="book-author">
                by <?= htmlspecialchars($ratedBook['Author']) ?>
                <div class="your-rating" data-book-id="<?= $ratedBook['Book_ID'] ?>">
                  Your rating: <?= $ratedBook['Rating'] ?>/10
                </div>
              </div>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
      <?php if (count($yourRatings) > $maxDisplay): ?>

  
<?php endif; ?>


    </div>
  <?php else: ?>
    <p>You have not rated any books yet.</p>
  <?php endif; ?>
</div>
</div>
    
    <!-- Wishlist Section -->
    <div id="wishlist-section">
    <div class="profile-section">
    <h3 id="ratings-title">
    Your Wishlist
</h3>

      <?php if(count($wishlist) > 0): ?>
        <div class="row tile-row">
        <?php foreach(array_slice($wishlist, 0, $maxDisplay) as $book): ?>

            <div class="col-md-3">
              <div class="book-tile">
                <a href="book_details.php?id=<?= $book['Book_ID'] ?>">
                  <div class="book-cover" style="background-image: url('<?= htmlspecialchars($book['Cover_Image']) ?>');"></div>
                  <div class="book-title">
                    <?= htmlspecialchars($book['Title']) ?>
                    
                  </div>
                  <div class="book-author">
                    by <?= htmlspecialchars($book['Author']) ?>
                    <?php
                // Fetch user rating for this book
                $stmt = $pdo->prepare("SELECT Rating FROM Rating WHERE Person_ID = ? AND Book_ID = ?");
                $stmt->execute([$userId, $book['Book_ID']]);
                $ratingData = $stmt->fetch();
                ?>
                <?php if($ratingData): ?>
                  <div class="your-rating" data-book-id="<?= $book['Book_ID'] ?>">
                    Your rating: <?= $ratingData['Rating'] ?>/10
                  </div>
                <?php else: ?>
                  <div class="rate-btn" data-book-id="<?= $book['Book_ID'] ?>">Rate</div>
                <?php endif; ?>
                  </div>
                </a>
                <div class="d-flex align-items-center justify-content-center">
                <button class="btn btn-sm btn-danger  remove-wishlist-btn mt-2" data-book-id="<?= $book['Book_ID'] ?>">Remove from Wishlist</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
          

<?php if (count($wishlist) > $maxDisplay): ?>
  <div class="col-md-3" id="viewAllWishlist">
    <div class="book-tile text-center d-flex flex-column justify-content-center align-items-center"  style="height: 100%;">
      <button class="btn btn-primary mt-5 backbtn" >View All</button>
    </div>
  </div>
<?php endif; ?>

        </div>
      <?php else: ?>
        <p>Your wishlist is empty.</p>
      <?php endif; ?>
    </div>
    </div>







    <div id="allwishlist">
    <div class="profile-section">
    <h3 id="ratings-title">
    Your Wishlist (<?= count($wishlist); ?>)
  <button id="backFromWishlist" class="btn btn-sm btn-secondary float-right backbtn d-none">Back</button>
</h3>

      <?php if(count($wishlist) > 0): ?>
        <div class="row tile-row">
        <?php foreach(array_slice($wishlist, 0, $allDisplay) as $book): ?>

            <div class="col-md-3">
              <div class="book-tile">
                <a href="book_details.php?id=<?= $book['Book_ID'] ?>">
                  <div class="book-cover" style="background-image: url('<?= htmlspecialchars($book['Cover_Image']) ?>');"></div>
                  <div class="book-title">
                    <?= htmlspecialchars($book['Title']) ?>
                    
                  </div>
                  <div class="book-author">
                    by <?= htmlspecialchars($book['Author']) ?>
                    <?php
                // Fetch user rating for this book
                $stmt = $pdo->prepare("SELECT Rating FROM Rating WHERE Person_ID = ? AND Book_ID = ?");
                $stmt->execute([$userId, $book['Book_ID']]);
                $ratingData = $stmt->fetch();
                ?>
                <?php if($ratingData): ?>
                  <div class="your-rating" data-book-id="<?= $book['Book_ID'] ?>">
                    Your rating: <?= $ratingData['Rating'] ?>/10
                  </div>
                <?php else: ?>
                  <div class="rate-btn" data-book-id="<?= $book['Book_ID'] ?>">Rate</div>
                <?php endif; ?>
                  </div>
                </a>
                <div class="d-flex align-items-center justify-content-center">
                <button class="btn btn-sm btn-danger  remove-wishlist-btn mt-2" data-book-id="<?= $book['Book_ID'] ?>">Remove from Wishlist</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
          
        </div>
      <?php else: ?>
        <p>Your wishlist is empty.</p>
      <?php endif; ?>
    </div>
    </div>







    <!-- Reviews Section -->
    <div id="reviews-section">
    <div class="profile-section ">
    <h3 id="ratings-title">
  Your Reviews
</h3>

      <?php if(count($reviews) > 0): ?>
        <?php foreach(array_slice($reviews, 0, $maxDisplay) as $review): ?>
          <div class="review-item">
            <p><strong>Book:</strong> <?= htmlspecialchars($review['book_title']) ?></p>
            <h5><?= htmlspecialchars($review['Title']) ?></h5>
            <p><?= nl2br(htmlspecialchars($review['Content'])) ?></p>
            <p>Rating: <?= isset($review['Rating']) ? $review['Rating']."/10" : "Not Rated" ?></p>
            <p><small><?= date('M d, Y', strtotime($review['Review_Date'])) ?></small></p>
            <div class="review-buttons" style="display: flex; justify-content: flex-end; align-items: center;">
              <button class="btn btn-sm btn-warning edit-review-btn"
                      data-subject="<?= htmlspecialchars($review['Title']) ?>"
                      data-content="<?= htmlspecialchars($review['Content']) ?>"
                      data-spoilers="<?= $review['Contains_Spoilers'] ? '1' : '0' ?>"
                      data-rating="<?= isset($review['Rating']) ? $review['Rating'] : 1; ?>"
                      data-bookid="<?= $review['Book_ID']; ?>">Edit Review</button>
              <a onclick="return confirm('Are you sure you want to delete this Review?');" href="delete_review.php?id=<?= $review['Person_ID']."_".$review['Book_ID'] ?>&redirect=profile.php" class="btn btn-sm btn-danger delete-review-btn">Delete</a>
              <a href="book_details.php?id=<?= $review['Book_ID']; ?>" class="btn btn-sm btn-info details-btn">Details</a>
            </div>
          </div>
        <?php endforeach; ?>
        
<?php if (count($reviews) > $maxDisplay): ?>
  <div class="col-md-3" id="viewAllReviews">
    <div class="book-tile text-center d-flex flex-column justify-content-center align-items-center"  style="width: 435%; height: 100%;">
      <button class="btn btn-primary mt-5 backbtn" >View All</button>
    </div>
  </div>
<?php endif; ?>


      <?php else: ?>
        <p>You have not posted any reviews yet.</p>
      <?php endif; ?>
    </div>
  </div>









  <div id="alllreviews">
    <div class="profile-section ">
    <h3 id="ratings-title">
  Your Reviews (<?= count($reviews); ?>)
  <button id="backFromReviews" class="btn btn-sm btn-secondary float-right  backbtn d-none">Back</button>
</h3>

      <?php if(count($reviews) > 0): ?>
        <?php foreach(array_slice($reviews, 0, $allDisplay) as $review): ?>
          <div class="review-item">
            <p><strong>Book:</strong> <?= htmlspecialchars($review['book_title']) ?></p>
            <h5><?= htmlspecialchars($review['Title']) ?></h5>
            <p><?= nl2br(htmlspecialchars($review['Content'])) ?></p>
            <p>Rating: <?= isset($review['Rating']) ? $review['Rating']."/10" : "Not Rated" ?></p>
            <p><small><?= date('M d, Y', strtotime($review['Review_Date'])) ?></small></p>
            <div class="review-buttons" style="display: flex; justify-content: flex-end; align-items: center;">
              <button class="btn btn-sm btn-warning edit-review-btn"
                      data-subject="<?= htmlspecialchars($review['Title']) ?>"
                      data-content="<?= htmlspecialchars($review['Content']) ?>"
                      data-spoilers="<?= $review['Contains_Spoilers'] ? '1' : '0' ?>"
                      data-rating="<?= isset($review['Rating']) ? $review['Rating'] : 1; ?>"
                      data-bookid="<?= $review['Book_ID']; ?>">Edit Review</button>
              <a href="delete_review.php?id=<?= $review['Person_ID']."_".$review['Book_ID'] ?>&redirect=profile.php" class="btn btn-sm btn-danger delete-review-btn">Delete</a>
              <a href="book_details.php?id=<?= $review['Book_ID']; ?>" class="btn btn-sm btn-info details-btn">Details</a>
            </div>
          </div>
        <?php endforeach; ?>



      <?php else: ?>
        <p>You have not posted any reviews yet.</p>
      <?php endif; ?>
    </div>
  </div>
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
  
  <!-- Review Modal (for editing/adding review) -->
  <div class="review-modal" id="reviewModal">
    <div class="review-modal-content">
      <span class="btn-close" id="closeReviewModal">&times;</span>
      <h5>Post a Review</h5>
      <form id="postReviewForm">
        <div class="form-group">
          <input type="text" name="subject" id="reviewSubject" class="form-control" placeholder="Subject" required>
        </div>
        <div class="form-group">
          <textarea name="content" id="reviewContent" rows="4" class="form-control" placeholder="Write your review here..." required></textarea>
        </div>
        <div class="form-group">
          <label>
            <input type="checkbox" name="contains_spoilers" id="containsSpoilers" value="1"> Contains Spoilers
          </label>
        </div>
        <div class="form-group">
          <label>Rating:</label>
          <select name="review_rating" id="reviewRating" class="form-control d-inline-block" style="width: auto;">
            <?php for($i = 1; $i <= 10; $i++): ?>
              <option value="<?= $i; ?>"><?= $i; ?></option>
            <?php endfor; ?>
          </select> / 10
        </div>
        <input type="hidden" name="book_id" id="reviewBookId" value="">
        <button type="submit" class="btn btn-success button sbm">Submit</button>
      </form>
    </div>
  </div>
  
  <!-- jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="js/profile.js"></script>


</body>
</html>
