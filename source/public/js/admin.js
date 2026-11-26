// Toggle sidebar
document.addEventListener('DOMContentLoaded', function () {
  var toggle = document.getElementById('sidebarToggle');
  if (toggle) {
    toggle.addEventListener('click', function () {
      document.body.classList.toggle('sidebar-toggled');
    });
  }

  // Tutup sidebar di mobile saat klik area gelap
  document.addEventListener('click', function (e) {
    if (window.innerWidth < 992 && document.body.classList.contains('sidebar-toggled')) {
      var sidebar = document.getElementById('sidebar');
      if (sidebar && !sidebar.contains(e.target) && e.target.id !== 'sidebarToggle' && !e.target.closest('#sidebarToggle')) {
        document.body.classList.remove('sidebar-toggled');
      }
    }
  });

  // Konfirmasi hapus
  document.querySelectorAll('form[data-confirm]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      if (!confirm(form.getAttribute('data-confirm'))) e.preventDefault();
    });
  });

  // Preview foto di form destinasi
  var fileInput = document.getElementById('imageFile');
  var urlInput = document.getElementById('imageUrl');
  var preview = document.getElementById('imagePreview');
  if (preview) {
    if (fileInput) {
      fileInput.addEventListener('change', function () {
        if (fileInput.files && fileInput.files[0]) {
          preview.src = URL.createObjectURL(fileInput.files[0]);
        }
      });
    }
    if (urlInput) {
      urlInput.addEventListener('change', function () {
        if (urlInput.value) preview.src = urlInput.value;
      });
    }
  }
});
