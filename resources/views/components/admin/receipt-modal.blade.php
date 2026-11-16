{{-- Full-size receipt viewer opened by any .show-receipt button on the page. --}}
<div id="receiptModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/80 p-4 backdrop-blur-sm"
    role="dialog" aria-modal="true" aria-labelledby="receiptModalTitle">
    <div class="relative flex max-h-full w-full max-w-4xl flex-col rounded-2xl bg-white p-3 shadow-2xl dark:bg-slate-900">
        <div class="mb-2 flex items-center justify-between gap-4 px-2">
            <h2 id="receiptModalTitle" class="truncate font-semibold text-slate-800 dark:text-slate-100"></h2>
            <div class="flex shrink-0 items-center gap-1">
                <a id="receiptModalOpen" href="#" target="_blank" rel="noopener"
                    class="rounded-lg px-3 py-1.5 text-xs font-semibold text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-500/10">
                    Open original
                </a>
                <button type="button" id="closeReceiptModal" aria-label="Close image"
                    class="rounded-lg px-3 py-1 text-xl text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800">×</button>
            </div>
        </div>
        <div class="flex min-h-0 items-center justify-center overflow-auto rounded-xl bg-slate-50 dark:bg-slate-800">
            <img id="receiptModalImage" src="" alt="Expense receipt" class="max-h-[78vh] max-w-full object-contain">
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('receiptModal');
        const modalImage = document.getElementById('receiptModalImage');
        const modalTitle = document.getElementById('receiptModalTitle');
        const modalOpen = document.getElementById('receiptModalOpen');

        const closeModal = () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modalImage.src = '';
        };

        document.addEventListener('click', event => {
            const button = event.target.closest('.show-receipt');

            if (!button) {
                return;
            }

            modalImage.src = button.dataset.receiptUrl;
            modalImage.alt = `Receipt for ${button.dataset.receiptTitle}`;
            modalTitle.textContent = button.dataset.receiptTitle;
            modalOpen.href = button.dataset.receiptUrl;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        document.getElementById('closeReceiptModal').addEventListener('click', closeModal);
        modal.addEventListener('click', event => {
            if (event.target === modal) {
                closeModal();
            }
        });
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    });
</script>
