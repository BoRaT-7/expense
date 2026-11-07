 @extends('admin.layouts.app')

 @section('title', 'Categories')

 @section('content')

     <div class="mx-auto max-w-7xl space-y-7">

         {{-- Page Header --}}
         <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

             <div>
                 <div class="mb-3 flex items-center gap-2 text-sm text-slate-400">
                     <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                     <span>/</span>
                     <span class="font-semibold text-blue-600">Categories</span>
                 </div>

                 <h1 class="text-2xl font-extrabold tracking-tight text-slate-800 md:text-3xl">
                     Expense Categories
                 </h1>

                 <p class="mt-2 text-sm text-slate-500">
                     Organize and manage your expense categories in one place.
                 </p>
             </div>

             <button type="button" onclick="openCategoryModal()"
                 class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">
                 <span class="text-xl">+</span>
                 Add New Category
             </button>

         </div>


         {{-- Summary Cards --}}

         {{-- Summary Cards --}}
         <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

             {{-- Total Categories --}}
             <div
                 class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-blue-200 hover:shadow-lg">
                 <div class="flex items-start justify-between">
                     <div>
                         <p class="text-sm font-medium text-slate-500">
                             Total Categories
                         </p>
                         <h3 id="totalCategories" class="mt-3 text-2xl font-bold tracking-tight text-slate-800">
                             6
                         </h3>
                         <p class="mt-2 text-xs font-medium text-slate-400">
                             All categories
                         </p>
                     </div>

                     <div
                         class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-2xl text-blue-600 transition-colors duration-300 group-hover:bg-blue-600 group-hover:text-white">
                         ◆
                     </div>
                 </div>

                 <div class="absolute bottom-0 left-0 h-1 w-full bg-blue-500"></div>
             </div>

             {{-- Active Categories --}}
             <div
                 class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-lg">
                 <div class="flex items-start justify-between">
                     <div>
                         <p class="text-sm font-medium text-slate-500">
                             Active Categories
                         </p>
                         <h3 id="activeCategories" class="mt-3 text-2xl font-bold tracking-tight text-slate-800">
                             6
                         </h3>
                         <p class="mt-2 text-xs font-medium text-slate-400">
                             Currently available
                         </p>
                     </div>

                     <div
                         class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-2xl text-emerald-600 transition-colors duration-300 group-hover:bg-emerald-600 group-hover:text-white">
                         ✓
                     </div>
                 </div>

                 <div class="absolute bottom-0 left-0 h-1 w-full bg-emerald-500"></div>
             </div>

             {{-- Total Expenses --}}
             <div
                 class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-violet-200 hover:shadow-lg">
                 <div class="flex items-start justify-between">
                     <div>
                         <p class="text-sm font-medium text-slate-500">
                             Total Expenses
                         </p>
                         <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-800">
                             ৳ 32,450
                         </h3>
                         <p class="mt-2 text-xs font-medium text-slate-400">
                             Sample amount
                         </p>
                     </div>

                     <div
                         class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-2xl font-semibold text-violet-600 transition-colors duration-300 group-hover:bg-violet-600 group-hover:text-white">
                         ৳
                     </div>
                 </div>

                 <div class="absolute bottom-0 left-0 h-1 w-full bg-violet-500"></div>
             </div>

             {{-- Most Used Category --}}
             <div
                 class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-amber-200 hover:shadow-lg">
                 <div class="flex items-start justify-between">
                     <div>
                         <p class="text-sm font-medium text-slate-500">
                             Most Used Category
                         </p>
                         <h3 class="mt-3 text-xl font-bold tracking-tight text-slate-800">
                             Utilities
                         </h3>
                         <p class="mt-2 text-xs font-medium text-slate-400">
                             Sample data
                         </p>
                     </div>

                     <div
                         class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-2xl text-amber-600 transition-colors duration-300 group-hover:bg-amber-500 group-hover:text-white">
                         ★
                     </div>
                 </div>

                 <div class="absolute bottom-0 left-0 h-1 w-full bg-amber-500"></div>
             </div>

         </div>


         {{-- Search and View Controls --}}
         <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

             <div>
                 <h2 class="text-lg font-bold text-slate-800">All Categories</h2>
                 <p class="mt-1 text-xs text-slate-400">Manage your expense classification.</p>
             </div>

             <div class="relative w-full sm:max-w-sm">
                 <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">⌕</span>
                 <input type="search" id="categorySearch" placeholder="Search categories..."
                     class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm outline-none transition focus:border-blue-500">
             </div>

         </div>


         {{-- Category Cards --}}


         {{-- Empty Search State --}}
         <div id="emptyCategories"
             class="hidden rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
             <div class="text-4xl">🔎</div>
             <h3 class="mt-4 font-bold text-slate-800">No categories found</h3>
             <p class="mt-2 text-sm text-slate-400">Try searching with another category name.</p>
         </div>

     </div>


     {{-- Add / Edit Category Modal --}}
     <div id="categoryModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/50 p-4">

         <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">

             <div class="mb-6 flex items-center justify-between">
                 <div>
                     <h2 id="modalTitle" class="text-xl font-extrabold text-slate-800">Add New Category</h2>
                     <p class="mt-1 text-xs text-slate-400">Create a category for your expenses.</p>
                 </div>

                 <button type="button" onclick="closeCategoryModal()"
                     class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100">✕</button>
             </div>

             <form id="categoryForm" class="space-y-4">

                 <div>
                     <label class="mb-2 block text-sm font-semibold text-slate-600">Category Name</label>
                     <input type="text" id="categoryName" required maxlength="40" placeholder="e.g. Office Supplies"
                         class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-blue-500">
                 </div>

                 <div>
                     <label class="mb-2 block text-sm font-semibold text-slate-600">Description</label>
                     <textarea id="categoryDescription" rows="3" maxlength="150" placeholder="Write a short description..."
                         class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-blue-500"></textarea>
                 </div>


                 <div class="flex gap-3 pt-2">
                     <button type="button" onclick="closeCategoryModal()"
                         class="flex-1 rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                         Cancel
                     </button>

                     <button type="submit"
                         class="flex-1 rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                         Save Category
                     </button>
                 </div>

             </form>

         </div>

     </div>


     @push('scripts')
         <script>
             // Search Categories
             const categorySearch = document.getElementById('categorySearch');

             categorySearch.addEventListener('input', function() {

                 const search = this.value.toLowerCase().trim();

                 const cards = document.querySelectorAll('.category-card');

                 let visibleCount = 0;

                 cards.forEach(card => {

                     const name = card.dataset.name.toLowerCase();

                     const visible = name.includes(search);

                     card.classList.toggle('hidden', !visible);

                     if (visible) visibleCount++;

                 });

                 document.getElementById('emptyCategories')
                     .classList.toggle('hidden', visibleCount > 0);

             });


             // Modal Controls
             const modal = document.getElementById('categoryModal');
             const categoryForm = document.getElementById('categoryForm');

             let editingCard = null;

             function openCategoryModal() {

                 editingCard = null;

                 categoryForm.reset();

                 document.getElementById('modalTitle').textContent = 'Add New Category';

                 modal.classList.remove('hidden');
                 modal.classList.add('flex');

             }

             function closeCategoryModal() {

                 modal.classList.add('hidden');
                 modal.classList.remove('flex');

             }


             // Add / Edit Category
             categoryForm.addEventListener('submit', function(event) {

                 event.preventDefault();

                 const name = document.getElementById('categoryName').value.trim();

                 const description = document.getElementById('categoryDescription').value.trim();

                 const icon = document.getElementById('categoryIcon').value.trim() || '📁';

                 if (!name) return;

                 if (editingCard) {

                     editingCard.querySelector('.category-name').textContent = name;

                     editingCard.querySelector('p.mt-1').textContent = description;

                     editingCard.querySelector('.text-3xl').textContent = icon;

                     editingCard.dataset.name = name.toLowerCase();

                 } else {

                     const card = document.createElement('div');

                     card.className =
                         'category-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg';

                     card.dataset.name = name.toLowerCase();

                     //          card.innerHTML = `
            //     <div class="flex items-start justify-between">
            //         <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-3xl">${icon}</div>
            //         <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">Active</span>
            //     </div>

            //     <h3 class="category-name mt-5 text-lg font-bold text-slate-800"></h3>
            //     <p class="mt-1 text-sm text-slate-400"></p>

            //     <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
            //         <div>
            //             <p class="text-xs text-slate-400">Total Expenses</p>
            //             <p class="mt-1 font-bold text-slate-800">৳ 0</p>
            //         </div>
            //         <div class="text-right">
            //             <p class="text-xs text-slate-400">Transactions</p>
            //             <p class="mt-1 font-bold text-slate-800">0</p>
            //         </div>
            //     </div>

            //     <div class="mt-4 flex gap-2">
            //         <button type="button" onclick="editCategory(this)" class="flex-1 rounded-lg border border-slate-200 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">Edit</button>
            //         <button type="button" onclick="deleteCategory(this)" class="rounded-lg border border-red-100 px-4 py-2 text-sm font-semibold text-red-500 hover:bg-red-50">Delete</button>
            //     </div>
            // `;

                     card.querySelector('.category-name').textContent = name;
                     card.querySelector('p.mt-1').textContent = description || 'No description provided.';

                     document.getElementById('categoryGrid').appendChild(card);

                 }

                 updateCategoryCount();

                 closeCategoryModal();

                 categoryForm.reset();

                 categorySearch.dispatchEvent(new Event('input'));

             });


             // Edit Category
             function editCategory(button) {

                 editingCard = button.closest('.category-card');

                 document.getElementById('modalTitle').textContent = 'Edit Category';

                 document.getElementById('categoryName').value =
                     editingCard.querySelector('.category-name').textContent;

                 document.getElementById('categoryDescription').value =
                     editingCard.querySelector('p.mt-1').textContent;

                 document.getElementById('categoryIcon').value =
                     editingCard.querySelector('.text-3xl').textContent;

                 modal.classList.remove('hidden');
                 modal.classList.add('flex');

             }


             // Delete Category
             function deleteCategory(button) {

                 if (!confirm('Are you sure you want to delete this category?')) {
                     return;
                 }

                 button.closest('.category-card').remove();

                 updateCategoryCount();

                 categorySearch.dispatchEvent(new Event('input'));

             }


             // Update Category Statistics
             function updateCategoryCount() {

                 const cards = document.querySelectorAll('.category-card');

                 document.getElementById('totalCategories').textContent = cards.length;

                 document.getElementById('activeCategories').textContent = cards.length;

             }
         </script>
     @endpush

 @endsection
