<button type="button" id="theme-toggle" aria-label="Switch to dark mode" aria-pressed="false"
    class="group flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 transition duration-200 hover:-translate-y-0.5 hover:bg-slate-100 active:translate-y-0 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-slate-300 dark:hover:bg-slate-800"
    title="Switch to dark mode">
    <svg id="theme-toggle-moon" class="h-5 w-5 transition-transform duration-500 motion-safe:group-hover:-rotate-[20deg]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="1.8" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M20.3 15.3A8.5 8.5 0 018.7 3.7 8.5 8.5 0 1020.3 15.3z" />
    </svg>
    <svg id="theme-toggle-sun" class="hidden h-5 w-5 transition-transform duration-700 motion-safe:group-hover:rotate-90" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="1.8" aria-hidden="true">
        <circle cx="12" cy="12" r="4" />
        <path stroke-linecap="round" d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42" />
    </svg>
</button>

<script>
    (() => {
        const button = document.getElementById('theme-toggle');
        if (!button || button.dataset.initialized) return;
        button.dataset.initialized = 'true';

        const moon = document.getElementById('theme-toggle-moon');
        const sun = document.getElementById('theme-toggle-sun');
        const updateButton = () => {
            const isDark = document.documentElement.classList.contains('dark');
            const label = isDark ? 'Switch to light mode' : 'Switch to dark mode';
            button.setAttribute('aria-label', label);
            button.setAttribute('title', label);
            button.setAttribute('aria-pressed', String(isDark));
            moon.classList.toggle('hidden', isDark);
            sun.classList.toggle('hidden', !isDark);
        };

        updateButton();
        window.addEventListener('themechange', updateButton);
        button.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('deshexpense-theme', isDark ? 'dark' : 'light');
            updateButton();
            window.dispatchEvent(new CustomEvent('themechange', { detail: { dark: isDark } }));
        });
    })();
</script>
