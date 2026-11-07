<script>
    // Apply saved theme before page renders
    (function() {
        const savedTheme = localStorage.getItem('deshexpense-theme');

        const theme = savedTheme || 'light';

        document.documentElement.classList.toggle(
            'dark',
            theme === 'dark'
        );
    })();
</script>
