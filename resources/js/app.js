import { initSmoothNav, bodyGlitch } from './navigation/smoothnav.js';

initSmoothNav();
bodyGlitch();

// ── Sidebar helpers ───────────────────────────────────────────────
function openSidebar() {
    document.getElementById('sidebar').classList.remove('-translate-x-full');
    document.getElementById('sidebar-backdrop').classList.remove('hidden');
}

function closeSidebar() {
    document.getElementById('sidebar').classList.add('-translate-x-full');
    document.getElementById('sidebar-backdrop').classList.add('hidden');
}
// ── Notif dropdown ────────────────────────────────────────────────
function toggleNotif() {
    const panel = document.getElementById('notif-panel');
    if (panel) panel.classList.toggle('hidden');
}

// Close pag nag-click sa labas
// Palitan ang existing click listener
document.addEventListener('click', function (e) {
    if (e.target.closest('[data-action="open-sidebar"]'))  openSidebar();
    if (e.target.closest('[data-action="close-sidebar"]')) closeSidebar();

    if (e.target.closest('[data-action="toggle-notif"]')) {
        toggleNotif();
    } else if (!e.target.closest('#notif-panel')) {
        document.getElementById('notif-panel')?.classList.add('hidden');
    }
});


// ── Active nav sync — aware sa custom colors via data attributes ──
function syncActiveNav() {
    const currentPath = window.location.pathname;

    document.querySelectorAll('[data-ajax-link]').forEach((link) => {
        const linkPath = new URL(link.href, window.location.origin).pathname;
        const isActive = linkPath === currentPath;

        // Basahin ang classes mula sa data attributes na naka-set ng PHP
        const activeClass   = link.dataset.activeClass;
        const inactiveClass = link.dataset.inactiveClass;

        if (activeClass && inactiveClass) {
            link.className = isActive ? activeClass : inactiveClass;
        }
    });
}

// I-run sa initial load at after every AJAX swap
syncActiveNav();
window.addEventListener('smoothnav:after', syncActiveNav);