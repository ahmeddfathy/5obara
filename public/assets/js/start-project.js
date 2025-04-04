// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Form validation
const form = document.querySelector('.contact-form form');
if (form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form fields
        const name = form.querySelector('input[placeholder="الاسم"]');
        const phone = form.querySelector('input[placeholder="رقم الجوال"]');
        const email = form.querySelector('input[placeholder="البريد الإلكتروني"]');
        const projectType = form.querySelector('input[placeholder="نوع المشروع"]');
        const message = form.querySelector('textarea');
        
        // Simple validation
        let isValid = true;
        
        if (!name.value.trim()) {
            markInvalid(name, 'الرجاء إدخال الاسم');
            isValid = false;
        } else {
            markValid(name);
        }
        
        if (!phone.value.trim()) {
            markInvalid(phone, 'الرجاء إدخال رقم الجوال');
            isValid = false;
        } else {
            markValid(phone);
        }
        
        if (!email.value.trim()) {
            markInvalid(email, 'الرجاء إدخال البريد الإلكتروني');
            isValid = false;
        } else if (!isValidEmail(email.value)) {
            markInvalid(email, 'الرجاء إدخال بريد إلكتروني صحيح');
            isValid = false;
        } else {
            markValid(email);
        }
        
        if (!projectType.value.trim()) {
            markInvalid(projectType, 'الرجاء إدخال نوع المشروع');
            isValid = false;
        } else {
            markValid(projectType);
        }
        
        if (!message.value.trim()) {
            markInvalid(message, 'الرجاء إدخال رسالتك');
            isValid = false;
        } else {
            markValid(message);
        }
        
        if (isValid) {
            // Here you would typically send the form data to your server
            alert('تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.');
            form.reset();
        }
    });
}

// Helper functions
function markInvalid(element, message) {
    element.classList.add('is-invalid');
    const feedback = document.createElement('div');
    feedback.className = 'invalid-feedback';
    feedback.textContent = message;
    
    // Remove any existing feedback
    const existingFeedback = element.parentElement.querySelector('.invalid-feedback');
    if (existingFeedback) {
        existingFeedback.remove();
    }
    
    element.parentElement.appendChild(feedback);
}

function markValid(element) {
    element.classList.remove('is-invalid');
    const feedback = element.parentElement.querySelector('.invalid-feedback');
    if (feedback) {
        feedback.remove();
    }
}

function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Add floating effect to process steps on scroll
const processSteps = document.querySelectorAll('.process-step');
if (processSteps.length) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.transform = 'translateY(0)';
                entry.target.style.opacity = '1';
            }
        });
    }, { threshold: 0.1 });

    processSteps.forEach((step, index) => {
        step.style.transform = 'translateY(20px)';
        step.style.opacity = '0';
        step.style.transition = `all 0.5s ease ${index * 0.1}s`;
        observer.observe(step);
    });
}

// Start project page functionality
document.addEventListener('DOMContentLoaded', function() {
    // Add any start project specific functionality here
    const ctaButtons = document.querySelectorAll('.btn-primary');
    ctaButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            // Add your CTA button logic here
            alert('سيتم التواصل معك قريباً!');
        });
    });
}); 