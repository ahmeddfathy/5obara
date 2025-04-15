// Counter animation for statistics numbers
document.addEventListener('DOMContentLoaded', function() {
    const statNumbers = document.querySelectorAll('.stat-number');

    function animateCounter(element, target) {
        let current = 0;
        const duration = 2000; // 2 seconds
        const step = Math.ceil(target / (duration / 20)); // Update every 20ms

        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = current;
            }
        }, 20);
    }

    // Check if element is in viewport
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // Start animation when stats section is in viewport
    function checkStatsVisibility() {
        const statsSection = document.querySelector('.stats-section');
        if (statsSection && isInViewport(statsSection)) {
            statNumbers.forEach(statNumber => {
                const target = parseInt(statNumber.textContent, 10);
                statNumber.textContent = '0';
                animateCounter(statNumber, target);
            });
            window.removeEventListener('scroll', checkStatsVisibility);
        }
    }

    // Check visibility on page load and scroll
    checkStatsVisibility();
    window.addEventListener('scroll', checkStatsVisibility);
});
