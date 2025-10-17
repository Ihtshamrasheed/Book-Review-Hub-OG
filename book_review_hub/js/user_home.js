

  $('#genreFilter, #sortSelect').on('change', function () {
    const genre = $('#genreFilter').val();
    const sort = $('#sortSelect').val();

    $.ajax({
      url: 'filter_books.php',
      method: 'GET',
      data: { genre: genre, sort: sort },
      success: function (response) {
        $('.row').html(response); // Replace book tiles
      }
    });
  });