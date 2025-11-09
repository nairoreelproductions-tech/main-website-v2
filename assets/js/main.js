/**
 * ==========================================
 * NAIROREEL CLIENT PORTAL - MAIN JAVASCRIPT
 * 
 * SECTIONS:
 * 1. Form Validation - Login form checks
 * 2. UI Interactions - Button effects, etc (to be added)
 * 3. Ajax Functions - Dynamic content loading (to be added)
 * ==========================================
 */

// ==========================================
// 1. FORM VALIDATION
// Basic validation for login forms
// ==========================================

document.addEventListener('DOMContentLoaded', function() {
    
    // Get login form if it exists
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            
            // Basic validation
            if (email === '' || password === '') {
                e.preventDefault();
                showError('Please fill in all fields');
                return false;
            }
            
            // Email format check
            if (!isValidEmail(email)) {
                e.preventDefault();
                showError('Please enter a valid email address');
                return false;
            }
        });
    }
});

// Email validation helper
function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Show error message
function showError(message) {
    const errorDiv = document.querySelector('.error-message');
    if (errorDiv) {
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
    }
}
