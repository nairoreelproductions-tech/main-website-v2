<?php
/**
 * Handle Password Reset Request
 * Sends email to Maria with reset request
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userEmail = clean($_POST['user_email'] ?? '');
    
    // Get user info if email provided
    $userName = 'Unknown User';
    $clientId = 'N/A';
    
    if (!empty($userEmail)) {
        try {
            $stmt = $conn->prepare("
                SELECT u.id, u.email, c.company_name, c.id as client_id 
                FROM users u
                LEFT JOIN client_users cu ON u.id = cu.user_id
                LEFT JOIN clients c ON cu.client_id = c.id
                WHERE u.email = ? AND u.role = 'client'
            ");
            $stmt->execute([$userEmail]);
            $user = $stmt->fetch();
            
            if ($user) {
                $userName = $user['company_name'] ?? $user['email'];
                $clientId = $user['client_id'] ?? 'N/A';
            }
        } catch (PDOException $e) {
            // Continue with unknown user
        }
    }
    
    // Prepare email to Maria
    $to = 'maria@nairoreelproductions.com';
    $subject = 'Password Reset Request - Client Portal';
    $timestamp = date('F j, Y \a\t g:i A');
    
    $message = "
    Password Reset Request
    ========================
    
    A client has requested a password reset for the Nairoreel Client Portal.
    
    CLIENT DETAILS:
    ---------------
    Email: " . ($userEmail ?: 'Not provided') . "
    Company: $userName
    Client ID: $clientId
    Request Time: $timestamp
    
    ACTION REQUIRED:
    ----------------
    1. Verify the client's identity
    2. Generate a temporary password (expires in 12 hours)
    3. Update the user account in the admin portal
    4. Send new credentials to the client
    
    ---
    This is an automated message from the Nairoreel Client Portal.
    ";
    
    // Email headers
    $headers = "From: noreply@nairoreelproductions.com\r\n";
    $headers .= "Reply-To: " . ($userEmail ?: 'noreply@nairoreelproductions.com') . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Send email
    $mailSent = mail($to, $subject, $message, $headers);
    
    // Always redirect to success (don't reveal if email exists or not for security)
    header('Location: contact-reset.php?success=1');
    exit();
    
} else {
    // If accessed directly, redirect to contact page
    header('Location: contact-reset.php');
    exit();
}
?>