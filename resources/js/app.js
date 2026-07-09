import { initSmoothNav, bodyGlitch } from './navigation/smoothnav.js';

document.addEventListener('DOMContentLoaded', () => {
    document.body.style.transition = 'opacity 0.15s ease';
    document.body.style.opacity = '1';
});

initSmoothNav();
bodyGlitch();