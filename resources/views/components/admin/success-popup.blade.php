{{--
    Success pop-up shown after an action, driven by the "popup" flash:
    ['type' => 'added'|'deleted', 'title' => string, 'message' => string]
--}}
@if (is_array($popup = session('popup')))
    <div id="successPopup" role="alertdialog" aria-modal="true" aria-labelledby="successPopupTitle" aria-describedby="successPopupMessage"
        class="fixed inset-0 z-[200] flex items-center justify-center bg-slate-950/45 p-4 opacity-0 backdrop-blur-sm transition-opacity duration-300 dark:bg-slate-950/65"
        data-state="open">

        <div data-popup-card class="relative w-full max-w-sm overflow-hidden rounded-[1.75rem] border border-white/80 bg-white p-7 text-center shadow-[0_24px_80px_-24px_rgba(15,23,42,0.42)] ring-1 ring-slate-900/[0.04] opacity-100 transition-[transform,opacity] duration-300 dark:border-slate-700 dark:bg-slate-900 dark:ring-white/[0.06] sm:p-8">
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-blue-500 via-sky-400 to-blue-600"></div>

            <div class="mx-auto flex h-[4.25rem] w-[4.25rem] items-center justify-center rounded-[1.4rem] bg-emerald-50 text-emerald-600 ring-8 ring-emerald-50/70 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/[0.06]">
                @if (($popup['type'] ?? 'added') === 'deleted')
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                    </svg>
                @else
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m5 12.5 4.2 4.2L19 7" />
                    </svg>
                @endif
            </div>

            <p class="mt-6 text-[11px] font-bold uppercase tracking-[0.2em] text-emerald-700 dark:text-emerald-300">{{ match ($popup['type'] ?? 'added') { 'deleted' => 'Action completed', 'added' => 'Expense added successfully', default => 'Saved successfully' } }}</p>
            <h2 id="successPopupTitle" class="mt-2 text-xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $popup['title'] ?? 'Success!' }}</h2>
            <p id="successPopupMessage" class="mx-auto mt-2 max-w-xs text-sm leading-6 text-slate-500 dark:text-slate-400">{{ $popup['message'] ?? '' }}</p>

            <button type="button" data-close-popup
                class="mt-7 inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition duration-200 hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-xl hover:shadow-blue-600/25 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-blue-500/25 active:translate-y-0 active:scale-[0.99]">
                Continue
            </button>

        </div>

    </div>

    <script>
        (() => {
            const popup = document.getElementById('successPopup');
            const okButton = popup.querySelector('[data-close-popup]');
            let closed = false;

            const closePopup = () => {
                if (closed) {
                    return;
                }

                closed = true;
                popup.classList.add('opacity-0');
                popup.querySelector('[data-popup-card]')?.classList.add('scale-95', 'opacity-0');
                setTimeout(() => popup.remove(), 300);
            };

            okButton.addEventListener('click', closePopup);
            okButton.focus();
            popup.addEventListener('click', event => {
                if (event.target === popup) {
                    closePopup();
                }
            });
            document.addEventListener('keydown', event => {
                if (event.key === 'Escape') {
                    closePopup();
                }
            });
            setTimeout(closePopup, 4000);
        })();
    </script>
@endif
