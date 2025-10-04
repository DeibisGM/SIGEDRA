import './bootstrap';
import './sidebar.js';

import { initDatepickers } from './custom-datepicker.js';

window.initDatepickers = initDatepickers;

document.addEventListener('DOMContentLoaded', function () {
    initDatepickers();

    if (document.getElementById('attendanceChart')) {
        import('./report-charts.js')
            .then(module => {
                const initCharts = module.default;
                initCharts();
            })
            .catch(err => console.error('Chart loading failed:', err));
    }

    let hasUnsavedChanges = false;
    const attendanceForm = document.getElementById('attendance-form');

    if (attendanceForm) {
        attendanceForm.addEventListener('change', () => {
            hasUnsavedChanges = true;
        });

        attendanceForm.addEventListener('submit', () => {
            hasUnsavedChanges = false;
        });

        // Listen for Livewire form submission success (if applicable)
        // Livewire typically prevents default submit, but this ensures the flag is reset
        document.addEventListener('livewire:navigated', () => {
            hasUnsavedChanges = false;
        });
        document.addEventListener('livewire:success', () => {
            hasUnsavedChanges = false;
        });
    }

    // Handle cancel buttons
    const cancelButtons = document.querySelectorAll('.cancel-attendance-form');
    cancelButtons.forEach(button => {
        button.addEventListener('click', () => {
            hasUnsavedChanges = false;
        });
    });

    let offlineIndicator = null;
    let isServerReachable = true; // New variable to track server reachability

    async function checkConnectivity() {
        try {
            await axios.get('/ping', { timeout: 5000 }); // Ping the server with a 5-second timeout
            if (!isServerReachable) {
                isServerReachable = true;
                updateOnlineStatus(); // Update status if it changed
            }
        } catch (error) {
            if (isServerReachable) {
                isServerReachable = false;
                updateOnlineStatus(); // Update status if it changed
            }
        }
    }

    function updateOnlineStatus() {
        if (!offlineIndicator) {
            offlineIndicator = document.getElementById('offline-indicator');
        }

        if (!offlineIndicator) {
            console.warn('Offline indicator element not found!');
            return;
        }

        // Consider the application offline if navigator.onLine is false OR if the server is not reachable
        const isActuallyOffline = !navigator.onLine || !isServerReachable;

        console.log('updateOnlineStatus called. navigator.onLine:', navigator.onLine, 'isServerReachable:', isServerReachable, 'isActuallyOffline:', isActuallyOffline);
        const attendanceForm = document.getElementById('attendance-form');
        const formElements = attendanceForm ? attendanceForm.querySelectorAll('input, select, textarea, button') : [];

        if (!isActuallyOffline) {
            console.log('Online. Hiding offline indicator.');
            offlineIndicator.classList.add('hidden');
            formElements.forEach(element => {
                element.removeAttribute('disabled');
            });
        } else {
            console.log('Offline. Showing offline indicator.');
            offlineIndicator.classList.remove('hidden');
            formElements.forEach(element => {
                element.setAttribute('disabled', 'disabled');
            });
        }
    }

    // Inside DOMContentLoaded
    // ... existing code ...

    // Online/Offline Status Detection
    offlineIndicator = document.getElementById('offline-indicator'); // Get element once on DOMContentLoaded

    if (offlineIndicator) {
        console.log('Offline indicator element found. Attaching event listeners.');
        // Set initial status
        updateOnlineStatus();

        // Listen for changes in native online status (still useful as a first indicator)
        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);

        // Start periodic connectivity check
        setInterval(checkConnectivity, 5000); // Check every 5 seconds
    } else {
        console.warn('Offline indicator element not found on DOMContentLoaded.');
    }

    window.addEventListener('beforeunload', (event) => {
        if (hasUnsavedChanges) {
            event.preventDefault();
            event.returnValue = ''; // Required for Chrome
        }
    });
});

document.addEventListener('livewire:navigated', () => {
    initDatepickers();
});
