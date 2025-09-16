document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.getElementById('mobile-menu-toggle');
    const closeButton = document.getElementById('sidebar-close-button');
    const sidebar = document.getElementById('application-sidebar');
    const backdrop = document.getElementById('sidebar-backdrop');

    const toggleSidebar = () => {
        if (sidebar) {
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }
    };

    if (toggleButton) {
        toggleButton.addEventListener('click', toggleSidebar);
    }

    if (closeButton) {
        closeButton.addEventListener('click', toggleSidebar);
    }

    if (backdrop) {
        backdrop.addEventListener('click', toggleSidebar);
    }
});
