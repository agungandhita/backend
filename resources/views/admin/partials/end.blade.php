<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Froala Editor JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>

<!-- Custom Scripts -->
<script>
    // Inisialisasi Froala Editor
    if (document.querySelector('.froala-editor')) {
        new FroalaEditor('.froala-editor', {
            // Konfigurasi editor
            toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', 'paragraphFormat',
                'align', 'formatOL', 'formatUL', 'indent', 'outdent',
                'insertImage', 'insertLink', 'insertTable', 'undo', 'redo'
            ],
            placeholderText: 'Tulis konten di sini...',
            language: 'id'
        });
    }

    // Notification toggle
    document.addEventListener('DOMContentLoaded', function() {
        const notificationToggle = document.getElementById('notification-toggle');
        const notificationDropdown = document.querySelector('.notification-dropdown');

        if (notificationToggle && notificationDropdown) {
            notificationToggle.addEventListener('click', function(e) {
                e.preventDefault();
                notificationDropdown.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!notificationToggle.contains(e.target) && !notificationDropdown.contains(e.target)) {
                    notificationDropdown.classList.remove('show');
                }
            });
        }
    });
</script>

@vite(['resources/js/app.js'])
@stack('scripts')
</body>

</html>
