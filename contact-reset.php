<?php
/**
 * Password Reset Contact Page
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$success = isset($_GET['success']) ? true : false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - Nairoreel Portal</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="contact-container">
        <div class="contact-box">
            <img src="assets/images/logo.webp" alt="Nairoreel Productions" class="logo">
            
            <h2>Password Reset Request</h2>
            
            <?php if ($success): ?>
                <div class="success-message">
                    Password reset request sent successfully! You'll receive new login credentials via email within 12 hours.
                </div>
            <?php else: ?>
                <p>Need help accessing your account? Contact our team to request a password reset.</p>
            <?php endif; ?>
            
            <div class="contact-info">
                <h3>Contact Information</h3>
                
                <div class="contact-item">
                    <strong>Communications Director</strong>
                    <span>Maria</span>
                </div>
                
                <div class="contact-item">
                    <strong>Email</strong>
                    <a href="mailto:maria@nairoreelproductions.com">maria@nairoreelproductions.com</a>
                </div>
                
                <div class="contact-item">
                    <strong>Phone</strong>
                    <span>+254 712 345 678</span>
                </div>
            </div>
            
            <?php if (!$success): ?>
                <form method="POST" action="request-reset.php">
                    <input type="hidden" name="user_email" id="userEmail">
                    <button type="submit" class="btn">Request Password Reset</button>
                </form>
            <?php endif; ?>
            
            <a href="index.php" class="back-link">← Back to Login</a>
        </div>
    </div>
    
    <script>
        // Capture email from URL parameter if available
        const urlParams = new URLSearchParams(window.location.search);
        const email = urlParams.get('email');
        if (email) {
            document.getElementById('userEmail').value = email;
        }
    </script>
</body>
</html>