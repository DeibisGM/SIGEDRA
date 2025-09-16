import '../../node_modules/@phosphor-icons/web/src/regular/style.css';
import '../../node_modules/@phosphor-icons/web/src/fill/style.css';

import './bootstrap';
import './sidebar.js';
import 'preline';

import flatpickr from "flatpickr";

document.addEventListener('DOMContentLoaded', function () {
    flatpickr(".flatpickr", {});
});