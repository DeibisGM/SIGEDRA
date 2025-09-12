import './bootstrap';
import 'preline';

// Manually initialize Preline components on page load
window.HSStaticMethods.autoInit();

// Re-initialize Preline components after Livewire navigation to handle dynamic content
document.addEventListener('livewire:navigated', () => {
    setTimeout(() => {
        window.HSStaticMethods.autoInit();
    }, 100); // A small delay can help ensure all elements are loaded
});
