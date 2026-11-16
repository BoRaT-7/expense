document.addEventListener('DOMContentLoaded', function () {

    // Sidebar Toggle
    window.toggleSidebar = function () {
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        if (!sidebar || !overlay) return;

        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
        document.body.classList.toggle('overflow-hidden');
    };

    // Calendar
    const button   = document.getElementById('datePickerButton');
    const dropdown = document.getElementById('calendarDropdown');
    const input    = document.getElementById('dashboardDate');
    const errorEl  = document.getElementById('dateError');
    const title    = document.getElementById('calendarTitle');
    const grid     = document.getElementById('calendarGrid');
    const label    = document.getElementById('selectedDateText');
    const prevBtn  = document.getElementById('prevMonth');
    const nextBtn  = document.getElementById('nextMonth');
    const applyBtn = document.getElementById('applyDate');
    const resetBtn = document.getElementById('resetDate');

    if (!button || !dropdown || !input || !grid) return;

    const MONTHS = ['January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'];

    const today = new Date();
    let viewYear  = today.getFullYear();
    let viewMonth = today.getMonth();
    let selected  = null; // Date or null

    const pad = n => String(n).padStart(2, '0');
    const fmt = d => `${pad(d.getDate())}/${pad(d.getMonth() + 1)}/${d.getFullYear()}`;
    const sameDay = (a, b) =>
        a && b && a.getFullYear() === b.getFullYear() &&
        a.getMonth() === b.getMonth() && a.getDate() === b.getDate();

    // Parse "12/05/24", "12-05-2024", "12.05.24" (day/month/year)
    function parseDate(text) {
        const m = text.trim().match(/^(\d{1,2})[\/\-.](\d{1,2})[\/\-.](\d{2}|\d{4})$/);
        if (!m) return null;

        const day = +m[1];
        const month = +m[2];
        let year = +m[3];
        if (m[3].length === 2) year += 2000;

        const d = new Date(year, month - 1, day);
        const valid = d.getFullYear() === year && d.getMonth() === month - 1 && d.getDate() === day;
        return valid ? d : null;
    }

    function render() {
        title.textContent = `${MONTHS[viewMonth]} ${viewYear}`;
        grid.innerHTML = '';

        const firstWeekday = new Date(viewYear, viewMonth, 1).getDay();
        const daysInMonth  = new Date(viewYear, viewMonth + 1, 0).getDate();

        for (let i = 0; i < firstWeekday; i++) {
            grid.appendChild(document.createElement('div'));
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(viewYear, viewMonth, day);
            const cell = document.createElement('button');
            cell.type = 'button';
            cell.textContent = day;
            cell.dataset.day = day;

            let cls = 'h-8 w-full rounded-lg text-xs font-medium transition-colors sm:h-9 sm:text-sm ';
            if (sameDay(date, selected)) {
                cls += 'bg-blue-600 text-white';
            } else if (sameDay(date, today)) {
                cls += 'border border-blue-400 text-blue-700 hover:bg-blue-50';
            } else {
                cls += 'text-slate-700 hover:bg-blue-50';
            }
            cell.className = cls;
            grid.appendChild(cell);
        }
    }

    function changeMonth(step) {
        viewMonth += step;
        if (viewMonth < 0)  { viewMonth = 11; viewYear--; }
        if (viewMonth > 11) { viewMonth = 0;  viewYear++; }
        render();
    }

    function setDropdown(open) {
        dropdown.classList.toggle('hidden', !open);
        if (open) render();
    }

    function announce() {
        document.dispatchEvent(new CustomEvent('dashboard:date-change', {
            detail: { date: selected, text: selected ? fmt(selected) : 'This Month' }
        }));
    }

    // Open / close
    button.addEventListener('click', function () {
        setDropdown(dropdown.classList.contains('hidden'));
    });

    // Keep clicks inside the dropdown from closing it (the grid is re-rendered,
    // so the clicked element may no longer be inside the dropdown afterwards)
    dropdown.addEventListener('click', e => e.stopPropagation());
    button.addEventListener('click', e => e.stopPropagation());
    document.addEventListener('click', () => setDropdown(false));

    // Manual month change
    prevBtn.addEventListener('click', () => changeMonth(-1));
    nextBtn.addEventListener('click', () => changeMonth(1));

    // Click a day
    grid.addEventListener('click', function (e) {
        const cell = e.target.closest('[data-day]');
        if (!cell) return;

        selected = new Date(viewYear, viewMonth, +cell.dataset.day);
        input.value = fmt(selected);
        errorEl.classList.add('hidden');
        render();
    });

    // Typing a date: the calendar jumps to that month automatically
    input.addEventListener('input', function () {
        const value = input.value.trim();

        if (value === '') {
            selected = null;
            errorEl.classList.add('hidden');
            render();
            return;
        }

        const date = parseDate(value);
        if (date) {
            selected  = date;
            viewYear  = date.getFullYear();
            viewMonth = date.getMonth();
            errorEl.classList.add('hidden');
            render();
        } else if (value.length >= 8) {
            errorEl.classList.remove('hidden'); // only complain once it looks complete
        } else {
            errorEl.classList.add('hidden');
        }
    });

    // Apply
    applyBtn.addEventListener('click', function () {
        label.textContent = selected ? fmt(selected) : 'This Month';
        announce();
        setDropdown(false);
    });

    // Reset to this month
    resetBtn.addEventListener('click', function () {
        selected  = null;
        viewYear  = today.getFullYear();
        viewMonth = today.getMonth();
        input.value = '';
        errorEl.classList.add('hidden');
        label.textContent = 'This Month';
        render();
        announce();
        setDropdown(false);
    });

    render();
});
