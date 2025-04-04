// JavaScript for component functionality

document.addEventListener('DOMContentLoaded', function() {
    console.log('Components.js loaded');

    // Add active class to current navigation item
    const navLinks = document.querySelectorAll('.nav-link');
    const currentUrl = window.location.pathname;

    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentUrl || (currentUrl === '/' && href === '/')) {
            link.classList.add('active');
        }
    });

    // Initialize mobile navigation
    const mobileMenuToggle = document.querySelector('.navbar-toggler');
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            const navbarCollapse = document.querySelector('.navbar-collapse');
            if (navbarCollapse) {
                navbarCollapse.classList.toggle('show');
            }
        });
    }

    // Ensure all components have proper CSS classes
    const topBar = document.querySelector('.top-bar');
    if (topBar) {
        topBar.style.display = 'block';
        console.log('Top bar initialized');
    }

    const mainHeader = document.querySelector('.main-header');
    if (mainHeader) {
        mainHeader.style.display = 'block';
        console.log('Header initialized');
    }

    const mainFooter = document.querySelector('.main-footer');
    if (mainFooter) {
        mainFooter.style.display = 'block';
        console.log('Footer initialized');
    }

    // Initialize WhatsApp buttons
    const whatsappButtons = document.querySelectorAll('.chat-btn.whatsapp, .btn-whatsapp');
    whatsappButtons.forEach(button => {
        if (!button.getAttribute('href') || button.getAttribute('href') === '#') {
            button.setAttribute('href', 'https://wa.me/966569617288');
        }
    });
});
