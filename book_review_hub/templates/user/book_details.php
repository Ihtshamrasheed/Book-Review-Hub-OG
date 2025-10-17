<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($book['Title']) ?> - Review Hub</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/book_details.css">
  <link rel="stylesheet" href="../../public/css/styles.css">
  <link rel="stylesheet" href="../../public/css/header.css">


  <style>
    .wishlist-heart {
    font-size: 50px;
    cursor: pointer;
    color: <?= $inWishlist ? 'black' : '#000'; ?>;
  }
  </style>
</head>
<body>
  <!-- Header -->
  <?php include '../../src/includes/header.php'; ?>

  <!-- Main Content -->
  <div class="container main-content">
    <div class="row">
      <!-- Left Column (3/4 width) -->
      <div class="col-md-9">
        <!-- Description and Review Controls -->
        <div class="mb-3">
          <div class="description-bar">
            <div class="description-label">Description</div>
            <?= nl2br(htmlspecialchars($book['Description'])); ?>
          </div>
          <div class="review-controls">
            <label><span class="total-reviews">Total Reviews: <?= count($reviews); ?></span></label>
            <label><input type="checkbox" id="hideSpoilers"> Hide Spoilers</label>
            <label>
              Rating:
              <select id="ratingFilter" class="form-control d-inline-block" style="width: auto;">
                <option value="all">Show All</option>
                <?php for($i = 1; $i <= 10; $i++): ?>
                  <option value="<?= $i; ?>"><?= $i; ?> Star<?= $i > 1 ? 's' : ''; ?></option>
                <?php endfor; ?>
              </select>
            </label>
            <!-- Show "Edit Review" if a review exists, otherwise "+ Review" -->
            <?php if ($userReview): ?>
              <button class="btn btn-primary add-review-btn" id="openReviewModal">Edit Review</button>
            <?php else: ?>
              <button class="btn btn-primary add-review-btn" id="openReviewModal">+ Review</button>
            <?php endif; ?>
            <div class="clearfix"></div>
          </div>
        </div>
        <!-- Reviews List -->
        <div id="noReviewsMessage" style="display: none; text-align: center; margin-top: 20px; font-weight: bold;">
  No reviews to show yet
</div>

        <div id="reviewsList reviewsContainer">
          <?php foreach($reviews as $review): ?>
            <div class="card mb-2 review-card"
                 data-spoiler="<?= $review['Contains_Spoilers'] ? 'true' : 'false'; ?>"
                 data-rating="<?= $review['review_rating'] !== null ? (int)$review['review_rating'] : '0'; ?>">
                          <div class="card-body">
                            <h6 class="card-title">
                              <?= htmlspecialchars($review['Title']); ?> - by <?= htmlspecialchars($review['reviewer_name']); ?>
                              <?php if ($review['Contains_Spoilers']) echo " (Spoilers)"; ?>
                               - <?= isset($review['review_rating']) && $review['review_rating'] !== null ? $review['review_rating'] . "/10" : "Not Rated"; ?>
                            </h6>
                            <p class="card-text"><?= nl2br(htmlspecialchars($review['Content'])); ?></p>
                            <small class="dateofrev text-muted "><?= date('M d, Y', strtotime($review['Review_Date'])); ?></small>
                            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $review['Person_ID']): ?>
                              <div class="mt-2 d-flex float-right ">
                                <a onclick="return confirm('Are you sure you want to delete this Review?');" href="delete_review.php?id=<?= $review['Person_ID'] . "_" . $bookId; ?>" class=" btn-sm btn-danger">Delete</a>
                              </div>
                            <?php endif; ?>
                          </div>
                        </div>
                      <?php endforeach; ?>


                    </div>
<div id="reviewPagination" class="pagination-controls d-flex float-right"></div>

                  </div>
                  <!-- Right Column (1/4 width) -->

                  <div class="col-md-3">
                    <div class="book-cover" style="background-image: url('../<?= htmlspecialchars($book['Cover_Image']); ?>');"></div>
                    <div class="book-info mt-2">
                      <div class="book-title d-flex">
                      <p style="width: 281px;">  <?= htmlspecialchars($book['Title']); ?> </p>

                    <div id="wishlistHeart" style="font-size: 40px; margin-top: -17px; margin-right: 10px;" data-book-id="<?= $bookId; ?>">
                          <?= $inWishlist ? '&#9829;' : '&#9825;'; ?></div>
                            </div>
                          <div>

                      <div class="book-genres ">
                        <?php
                          $displayGenres = $book['Genre'];
                          echo (strlen($displayGenres) > 50) ? substr($displayGenres, 0, 50) . '...' : $displayGenres;
                        ?>
                      </div>
                      <div class="book-author">

  <!-- Author name -->
  by <?= htmlspecialchars($book['Author']) ?>
<br>
              <!-- Book average rating -->
  <div class="book-rating">
          <span   style="cursor:pointer; color:#ffc107; font-size: 20px">&#9733;</span>
    <?= htmlspecialchars($book['Curr_Rating']) != NULL
        ? number_format((float)htmlspecialchars($book['Curr_Rating']), 1) . "/10 (" . htmlspecialchars($book['Rating_User_Count']) . ")"
        : "N/A"; ?>
  </div>

                <!-- Rate Button or Your Rating -->
                <?php if(isset($_SESSION['user_id']) && isset($userRating)): ?>
                  <div class="your-rating" data-book-id="<?= $book['Book_ID'] ?>">
                    Your rating: <?= $userRating ?>/10
                  </div>
                <?php else: ?>
                  <div class="rate-btn " data-book-id="<?= $book['Book_ID'] ?>">Rate</div>
                <?php endif; ?>

              </div>
                      </div>
                    </div>
                  </div>
                </div>

  </div>


  <!-- Review Post Modal -->
  <div class="review-modal" id="reviewModal">
    <div class="review-modal-content">
      <span class="btn-close" id="closeReviewModal">&times;</span>
      <h5>Post a Review</h5>
      <form id="postReviewForm">
        <div class="form-group">
          <input type="text" name="subject" id="reviewSubject" class="form-control" placeholder="Subject" required value="<?= $userReview ? htmlspecialchars($userReview['Title']) : ''; ?>">
        </div>
        <div class="form-group">
          <textarea name="content" id="reviewContent" rows="4" class="form-control" placeholder="Write your review here..." required><?= $userReview ? htmlspecialchars($userReview['Content']) : ''; ?></textarea>
        </div>
        <div class="form-group">
          <label>
            <input type="checkbox" name="contains_spoilers" id="containsSpoilers" value="1" <?= ($userReview && $userReview['Contains_Spoilers']) ? 'checked' : ''; ?>> Contains Spoilers
          </label>
        </div>
        <div class="form-group">
          <label>Rating:</label>
          <?php $selectedRating = isset($userRating) ? $userRating : NULL; ?>
          <select name="review_rating" id="reviewRating" class="form-control d-inline-block" style="width: auto;">
            <?php for($i = 1; $i <= 10; $i++): ?>
              <option value="<?= $i; ?>" <?= ($i == $selectedRating) ? 'selected' : ''; ?>><?= $i; ?></option>
            <?php endfor; ?>
          </select> / 10
        </div>
        <input type="hidden" name="book_id" value="<?= $bookId; ?>">
        <button type="submit" class="btn btn-success button">Submit</button>
      </form>
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

  <!-- jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="../../public/js/book_details.js"></script>

</body>
</html>