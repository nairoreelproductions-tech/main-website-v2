<?php
/**
 * Client Login Page
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

// Redirect if already logged in
if (isLoggedIn() && isClient()) {
    header('Location: client/dashboard.php');
    exit();
}

$error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = clean($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (!empty($email) && !empty($password)) {
        try {
            // Check if user exists
            $stmt = $conn->prepare("SELECT id, email, password, temp_password, temp_password_expires, force_password_change, role FROM users WHERE email = ? AND role = 'client'");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if ($user) {
                $passwordValid = false;
                
                // Check if using temporary password
                if ($user['temp_password'] && $user['temp_password_expires']) {
                    if (strtotime($user['temp_password_expires']) > time()) {
                        // Temp password hasn't expired
                        if (password_verify($password, $user['temp_password'])) {
                            $passwordValid = true;
                            // User must change password
                            $_SESSION['must_change_password'] = true;
                        }
                    } else {
                        // Temp password expired
                        $error = 'Your temporary password has expired. Please request a new password reset.';
                    }
                }
                
                // Check regular password if temp password didn't work
                if (!$passwordValid && password_verify($password, $user['password'])) {
                    $passwordValid = true;
                }
                
                if ($passwordValid) {
                    // Login successful
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                    
                    // Update last login
                    $updateStmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                    $updateStmt->execute([$user['id']]);
                    
                    // Redirect to change password if using temp password
                    if (isset($_SESSION['must_change_password'])) {
                        header('Location: client/change-password.php');
                    } else {
                        header('Location: client/dashboard.php');
                    }
                    exit();
                } else if (empty($error)) {
                    $error = 'Invalid email or password';
                }
            } else {
                $error = 'Invalid email or password';
            }
        } catch (PDOException $e) {
            $error = 'Login failed. Please try again.';
        }
    } else {
        $error = 'Please fill in all fields';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Portal - Nairoreel Productions</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<svg xmlns="http://www.w3.org/2000/svg" version="1.1" class="hidden" style="position:absolute; width:0; height:0; overflow:hidden;">
  <defs>
    <filter id="noise-filter">
      <feTurbulence 
        type="fractalNoise" 
        baseFrequency="0.65" 
        numOctaves="3" 
        stitchTiles="stitch" />
    </filter>
  </defs>
</svg>

    <div class="login-container">
        <div class="login-box">
            <img src="public_html/assets/images/sf-logo-w.webp" alt="Nairoreel Productions" class="logo">
            
            <h2>CLIENT PORTAL</h2>
            <p class="subheader">Log in to manage your projects and tasks</p>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="" id="loginForm">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email Address" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                
                <div class="forgot-password">
                    <a href="contact-reset.php">Forgot Password?</a>
                </div>
                
                <button type="submit" class="btn">Sign In</button>
            </form>
        </div>
    </div>
    
    <script src="assets/js/main.js"></script>
</body>
</html>