<script>
    // Apply saved theme before page renders
    (function() {
        let savedTheme = null;
        try {
            savedTheme = localStorage.getItem('deshexpense-theme');
        } catch (e) {}

        // Fall back to the operating system preference when nothing is saved
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const theme = savedTheme || (prefersDark ? 'dark' : 'light');

        document.documentElement.classList.toggle(
            'dark',
            theme === 'dark'
        );
    })();
</script>
