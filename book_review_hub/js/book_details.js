// Show/Hide Review Modal
$('#openReviewModal').click(function(){
  $('#reviewModal').fadeIn();
});
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
        location.reload(); // refresh page to show new review
      } else {
        //alert(response.message);
      }
    }
  });
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
        //console.error('Error:', err);
        //alert('Something went wrong: ' + err.message);
    });
});


// Wishlist toggle via AJAX
$('#wishlistHeart').click(function(){
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

// Frontend pagination setup
let reviewsPerPage = 15;
let currentPage = 1;


function renderPagination(totalPages) {
  let container = $('#reviewPagination');
  if (!container.length) return;
  container.empty();

  if (totalPages <= 1) return;

  if (currentPage > 1) {
    container.append(`<button class="page-btn btn btn-primary" data-page="${currentPage - 1}">Previous</button>`);
  }

  for (let i = 1; i <= totalPages; i++) {
    let active = (i === currentPage) ? 'active-page' : '';
    container.append(`<button class="btn btn-primary page-btn ${active}"  data-page="${i}">${i}</button>`);
  }

  if (currentPage < totalPages) {
    container.append(`<button class="page-btn btn btn-primary" data-page="${currentPage + 1}">Next</button>`);
  }
}

$(document).on('click', '.page-btn', function() {
  let page = parseInt($(this).data('page'));
  showPage(page);
});

// Filtering logic with pagination call
function filterReviews() {
  var hideSpoilers = $('#hideSpoilers').is(':checked');
  var selectedRating = $('#ratingFilter').val();

  // First hide everything and tag what should be visible
  $('.review-card').hide().removeClass('filtered-in');

  $('.review-card').each(function() {
    var hasSpoiler = $(this).data('spoiler') === true || $(this).data('spoiler') === 'true';
    var reviewRating = $(this).data('rating');
    var show = true;

    if (hideSpoilers && hasSpoiler) show = false;
    if (selectedRating !== 'all' && reviewRating != selectedRating) show = false;

    if (show) {
      $(this).addClass('filtered-in'); // Mark as part of the filtered result
    }
  });

  let totalFiltered = $('.review-card.filtered-in').length;

  if (totalFiltered === 0) {
    $('#noReviewsMessage').show();
    $('#reviewPagination').empty();
  } else {
    $('#noReviewsMessage').hide();
    showPage(1); // Always start at page 1 after filtering
  }
}

function showPage(page) {
  let allFiltered = $('.review-card.filtered-in');
  let total = allFiltered.length;
  let totalPages = Math.ceil(total / reviewsPerPage);

  if (page < 1) page = 1;
  if (page > totalPages) page = totalPages;

  currentPage = page;
  $('.review-card').hide(); // hide all

  let start = (currentPage - 1) * reviewsPerPage;
  let end = start + reviewsPerPage;

  allFiltered.slice(start, end).show();
  renderPagination(totalPages);
}

// Apply Hide Spoilers on page load if checkbox is checked
$(document).ready(function(){
  if ($('#hideSpoilers').is(':checked')) {
    $('.review-card').each(function(){
      if ($(this).data('spoiler') === 'true') {
        $(this).hide();
      }
    });
  }
});

// Trigger filtering on change
$('#hideSpoilers, #ratingFilter').on('change', function() {
  filterReviews();
});

// On load, apply filters and paginate
$(document).ready(function(){
  filterReviews();
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
