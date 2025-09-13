document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.getElementById('mobile-menu-toggle');
    const closeButton = document.getElementById('sidebar-close-button');
    const sidebar = document.getElementById('application-sidebar');

    const toggleSidebar = () => {
        if (sidebar) {
            sidebar.classList.toggle('-translate-x-full');
        }
    };

    if (toggleButton) {
        toggleButton.addEventListener('click', toggleSidebar);
    }

    if (closeButton) {
        closeButton.addEventListener('click', toggleSidebar);
    }
});