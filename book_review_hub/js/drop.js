document.addEventListener('DOMContentLoaded', function () {
    const dropzone = document.getElementById('coverDropzone');
    const input = document.getElementById('coverInput');
    const preview = document.getElementById('coverPreview');
  
    dropzone.addEventListener('click', () => input.click());
  
    dropzone.addEventListener('dragover', (e) => {
      e.preventDefault();
      dropzone.classList.add('dragover');
    });
  
    dropzone.addEventListener('dragleave', () => {
      dropzone.classList.remove('dragover');
    });
  
    dropzone.addEventListener('drop', (e) => {
      e.preventDefault();
      dropzone.classList.remove('dragover');
      const file = e.dataTransfer.files[0];
      if (file && file.type.startsWith('image/')) {
        input.files = e.dataTransfer.files;
        previewFile(file);
      }
    });
  
    input.addEventListener('change', () => {
      const file = input.files[0];
      if (file && file.type.startsWith('image/')) {
        previewFile(file);
      }
    });
  
    function previewFile(file) {
      const reader = new FileReader();
      reader.onload = () => {
        preview.src = reader.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    }
  });
  
document.addEventListener('DOMContentLoaded', function () {
  const openBtn = document.getElementById('openGenreModal');
  const closeBtn = document.getElementById('closeGenreModal');
  const modal = document.getElementById('genreModal');
  const checkboxes = document.querySelectorAll('.genre-checkbox');
  const genreInput = document.getElementById('genreInput');
  const selectedGenresDisplay = document.getElementById('selectedGenres');

  // Load already selected genres from DB (from hidden input or server-side echo)
  let existingGenres = genreInput.value.split(',').map(g => g.trim()).filter(g => g !== "");

  // Pre-check boxes on load
  checkboxes.forEach(cb => {
    if (existingGenres.includes(cb.value)) {
      cb.checked = true;
    }
  });

  // Show modal
  openBtn.addEventListener('click', () => {
    modal.style.display = 'block';
  });

  // Hide modal & save selected genres
  closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';

    const selected = Array.from(checkboxes)
      .filter(cb => cb.checked)
      .map(cb => cb.value);

    // Store in hidden input for submission
    genreInput.value = selected.join(', ');

    // Update visible selected genre tags
    selectedGenresDisplay.innerHTML = '';
    selected.forEach(genre => {
      const span = document.createElement('span');
      span.className = 'badge badge-primary mr-1';
      span.innerText = genre;
      selectedGenresDisplay.appendChild(span);
    });
  });

  // Close modal if user clicks outside the modal box
  window.onclick = function (e) {
    if (e.target == modal) {
      modal.style.display = "none";
    }
  };
});
