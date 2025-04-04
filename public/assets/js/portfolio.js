/**
 * JavaScript para la sección de Portfolio
 */

document.addEventListener('DOMContentLoaded', function() {
    // Animación de aparición para los elementos del portfolio
    const portfolioItems = document.querySelectorAll('.portfolio-item');

    if (portfolioItems.length > 0) {
        portfolioItems.forEach((item, index) => {
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, 100 * index);
        });
    }

    // Inicializar efectos para elementos de portfolio
    initPortfolioEffects();

    // Gestionar clics en la paginación
    setupPagination();
});

/**
 * Inicializa efectos visuales para los elementos del portfolio
 */
function initPortfolioEffects() {
    // Si hay imágenes en el portfolio, añadir efecto de hover
    const portfolioImages = document.querySelectorAll('.portfolio-item img');

    if (portfolioImages.length > 0) {
        portfolioImages.forEach(img => {
            // Asegurar que las imágenes se cargan correctamente
            img.addEventListener('load', function() {
                this.parentElement.classList.add('loaded');
            });

            // Si la imagen ya está cargada
            if (img.complete) {
                img.parentElement.classList.add('loaded');
            }
        });
    }

    // Botones de contacto en el portfolio
    const contactButtons = document.querySelectorAll('.contact-btn, .view-btn');

    if (contactButtons.length > 0) {
        contactButtons.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
            });

            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    }
}

/**
 * Configura la funcionalidad de paginación
 */
function setupPagination() {
    const paginationLinks = document.querySelectorAll('.pagination li a');

    if (paginationLinks.length > 0) {
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Solo prevenir comportamiento por defecto para
                // enlaces de demostración que no tienen funcionalidad real
                if (this.getAttribute('href') === '#') {
                    e.preventDefault();

                    // Simular cambio de página (solo para demo)
                    document.querySelectorAll('.pagination li').forEach(li => {
                        li.classList.remove('active');
                    });

                    this.parentElement.classList.add('active');

                    // Scroll suave hacia arriba
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }
}

// Inicializar botones de chat
const chatButtons = document.querySelectorAll('.chat-btn');
if (chatButtons.length > 0) {
    chatButtons.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });

        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
}
