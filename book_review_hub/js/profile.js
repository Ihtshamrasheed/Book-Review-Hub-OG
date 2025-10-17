$(document).ready(function () {
  $('#alllratings').hide();
  $('#allwishlist').hide();
  $('#alllreviews').hide();

  function showOnlySection(sectionId, backBtnId) {
    $('.pfd').hide(); // Hide top user info

    // Hide all sections
    $('#ratings-section, #wishlist-section, #reviews-section').hide();
    $('#viewAllRatings, #viewAllWishlist, #viewAllReviews').hide();
    // Show only the selected section

    // Show only the selected back button
    $('#backFromRatings, #backFromWishlist, #backFromReviews').addClass('d-none');
    $(backBtnId).removeClass('d-none');
  }

  function showAllSections() {
    $('.pfd').show();
    $('#ratings-section, #wishlist-section, #reviews-section').show();
    $('#backFromRatings, #backFromWishlist, #backFromReviews').addClass('d-none');
    $('#viewAllRatings, #viewAllWishlist, #viewAllReviews').show();

  }
  

  $('#viewAllRatings').click(function () {
    showOnlySection('#ratings-section', '#backFromRatings');
  $('#alllratings').show();
    
    // TODO: Load paginated ratings via AJAX here
  });

  $('#viewAllWishlist').click(function () {
    showOnlySection('#wishlist-section', '#backFromWishlist');
  $('#allwishlist').show();

    // TODO: Load paginated wishlist via AJAX here
  });

  $('#viewAllReviews').click(function () {
    showOnlySection('#reviews-section', '#backFromReviews');
  $('#alllreviews').show();

    // TODO: Load paginated reviews via AJAX here
  });

  $('#backFromRatings, #backFromWishlist, #backFromReviews').click(function () {
    showAllSections();
  $('#alllratings').hide();
  $('#allwishlist').hide();
  $('#alllreviews').hide();
    
    // Optionally: restore first 7 only if content was replaced
  });
});












// Wishlist removal via AJAX for remove button in wishlist
$('.remove-wishlist-btn').click(function(e){
    e.preventDefault();
    e.stopPropagation();
    var bookId = $(this).data('book-id');
    $.post('wishlist.php', { book_id: bookId }, function(response){
      if(response.status === 'removed'){
        location.reload();
      } else {
        alert(response.message);
      }
    }, 'json');
  });
  
  // Wishlist heart toggle in tiles
  $('.wishlist-heart').click(function(e){
    e.preventDefault();
    e.stopPropagation();
    var bookId = $(this).data('book-id');
    var heart = $(this);
    $.post('wishlist.php', { book_id: bookId }, function(response){
      if(response.status === 'added'){
        heart.html('&#9829;');
        heart.css('color', 'black');
      } else if(response.status === 'removed'){
        heart.html('&#9825;');
        heart.css('color', 'black');
      }
    }, 'json');
  });
  
  
 // Reset stars when modal opens
function resetRatingModal() {
    selectedRating = 0;
    $('.star').css('color', '#ccc');
    $('#selectedRatingText').text('0/10');
}
    
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
      $('#selectedRatingText').text(selectedRating + '/10');
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


document.getElementById('postReviewForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    // Extract the rating and remove it from the review form data
    const rating = formData.get('review_rating');
    formData.delete('review_rating'); // Don't send rating to post_review.php

    // First, submit the review (without rating)
    fetch('post_review.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Now submit the rating separately to submit_rating.php
            const ratingData = new FormData();
            ratingData.append('book_id', formData.get('book_id'));
            ratingData.append('rating', rating);

            return fetch('submit_rating.php', {
                method: 'POST',
                body: ratingData
            });
        } else {
            //throw new Error(data.message || 'Failed to submit review.');
        }
    })
    .then(response => response.json())
    .catch(err => {
        console.error('Error:', err);
        //alert('Something went wrong: ' + err.message);
    });
});

  // Review Modal functionality (for posting/editing reviews)
  function openReviewModal(subject = '', content = '', spoilers = 0, rating = 1, bookId = '') {
    $('#reviewSubject').val(subject);
    $('#reviewContent').val(content);
    $('#containsSpoilers').prop('checked', (spoilers == 1));
    $('#reviewRating').val(rating);
    $('#reviewBookId').val(bookId);
    $('#reviewModal').fadeIn();
  }
  
  // When user clicks an Edit Review button in the reviews list, open modal with prefilled data.
  $(document).on('click', '.edit-review-btn', function(e){
    e.preventDefault();
    var subject = $(this).data('subject');
    var content = $(this).data('content');
    var spoilers = $(this).data('spoilers');
    var rating = $(this).data('rating');
    var bookId = $(this).data('bookid');
    openReviewModal(subject, content, spoilers, rating, bookId);
  });
  
  // Close review modal
  $('#closeReviewModal').click(function(){
    $('#reviewModal').fadeOut();
  });
  
  // Submit review via AJAX
  $('#postReviewForm').submit(function(e){
    e.preventDefault();
    $.ajax({
      url: 'post_review.php',
      method: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(response) {
        if(response.status === 'success'){
          $('#reviewModal').fadeOut();
          location.reload();
        } else {
          alert(response.message);
        }
      }
    });
  });
  
  