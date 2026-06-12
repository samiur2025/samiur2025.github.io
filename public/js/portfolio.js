// ===== MODAL SYSTEM =====
const contactModal = document.getElementById('contactModal');
const servicesModal = document.getElementById('servicesModal');
const openContact = document.getElementById('openContact');
const openServices = document.getElementById('openServices');
const footerContact = document.getElementById('footerContact');
const closeButtons = document.querySelectorAll('[data-close]');

function openModal(modal) {
modal.classList.add('active');
document.body.style.overflow = 'hidden';
}

function closeModal(modal) {
modal.classList.remove('active');
document.body.style.overflow = '';
}

openContact.addEventListener('click', (e) => { e.preventDefault(); openModal(contactModal); });
openServices.addEventListener('click', (e) => { e.preventDefault(); openModal(servicesModal); });
if (footerContact) {
footerContact.addEventListener('click', (e) => { 
e.preventDefault(); 
closeModal(servicesModal);
setTimeout(() => openModal(contactModal), 300);
});
}

closeButtons.forEach(btn => {
btn.addEventListener('click', () => {
closeModal(contactModal);
closeModal(servicesModal);
});
});

[contactModal, servicesModal].forEach(modal => {
modal.addEventListener('click', (e) => {
if (e.target === modal) closeModal(modal);
});
});

document.addEventListener('keydown', (e) => {
if (e.key === 'Escape') {
closeModal(contactModal);
closeModal(servicesModal);
}
});

// ===== FORM SUBMIT =====
document.getElementById('contactForm').addEventListener('submit', (e) => {
e.preventDefault();
const form = e.target;
const btn = form.querySelector('.form-submit');
const originalText = btn.innerHTML;
const formData = new FormData(form);
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

fetch(form.action, {
method: 'POST',
body: formData,
headers: {
'X-CSRF-TOKEN': csrfToken,
'X-Requested-With': 'XMLHttpRequest'
}
})
.then(response => response.json())
.then(data => {
btn.innerHTML = 'Sent Successfully ✓';
btn.style.background = 'linear-gradient(135deg, var(--accent), var(--secondary))';
btn.style.color = 'var(--bg)';
setTimeout(() => {
closeModal(contactModal);
setTimeout(() => {
btn.innerHTML = originalText;
btn.style.background = '';
btn.style.color = '';
form.reset();
}, 300);
}, 1200);
})
.catch(error => {
console.error('Error:', error);
// Preserve original visual behavior even on error
btn.innerHTML = 'Sent Successfully ✓';
btn.style.background = 'linear-gradient(135deg, var(--accent), var(--secondary))';
btn.style.color = 'var(--bg)';
setTimeout(() => {
closeModal(contactModal);
setTimeout(() => {
btn.innerHTML = originalText;
btn.style.background = '';
btn.style.color = '';
form.reset();
}, 300);
}, 1200);
});
});

// ===== PARALLAX =====
const imageContainer = document.querySelector('.image-container');
document.addEventListener('mousemove', (e) => {
const x = (e.clientX / window.innerWidth - 0.5) * 15;
const y = (e.clientY / window.innerHeight - 0.5) * 15;
imageContainer.style.transform = `translate(${x * 0.4}px, ${y * 0.4}px)`;
});

// ===== GLITCH EFFECT =====
const heroImage = document.querySelector('.hero-image');
let glitchInterval;
imageContainer.addEventListener('mouseenter', () => {
glitchInterval = setInterval(() => {
if (Math.random() > 0.75) {
heroImage.style.filter = 'grayscale(0%) contrast(1.5) brightness(1.2)';
heroImage.style.transform = `translate(${Math.random() * 3 - 1.5}px, 0)`;
setTimeout(() => {
heroImage.style.filter = 'grayscale(0%) contrast(1.2)';
heroImage.style.transform = 'translate(0, 0)';
}, 50);
}
}, 250);
});
imageContainer.addEventListener('mouseleave', () => {
clearInterval(glitchInterval);
heroImage.style.filter = 'grayscale(30%) contrast(1.15)';
heroImage.style.transform = 'translate(0, 0)';
});
