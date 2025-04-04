// Main JavaScript file for the site

document.addEventListener('DOMContentLoaded', function() {
    // Initialize menu toggle
    const menuToggle = document.querySelector('.navbar-toggler');
    const navMenu = document.querySelector('#navbarNav');

    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('show');
        });
    }

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });

    // WhatsApp button functionality
    const whatsappLinks = document.querySelectorAll('.chat-btn.whatsapp, .btn-whatsapp');
    whatsappLinks.forEach(link => {
        if (!link.getAttribute('href') || link.getAttribute('href') === '#') {
            link.setAttribute('href', 'https://wa.me/966569617288');
        }
    });
});
