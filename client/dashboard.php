<?php
/**
 * Client Dashboard
 */

require_once '../config/database.php';
require_once '../includes/functions.php';

// Check if user is logged in and is client
if (!isLoggedIn() || !isClient()) {
    header('Location: ../index.php');
    exit();
}

// Get client information
$userId = $_SESSION['user_id'];

try {
    // Get client details through client_users table
    $stmt = $conn->prepare("
        SELECT c.*, cu.role as client_role 
        FROM client_users cu 
        JOIN clients c ON cu.client_id = c.id 
        WHERE cu.user_id = ?
    ");
    $stmt->execute([$userId]);
    $clientInfo = $stmt->fetch();
    
} catch (PDOException $e) {
    $clientInfo = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard - Nairoreel Portal</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard">
        <h1>Welcome to Your Portal</h1>
        <p>Logged in as: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        
        <?php if ($clientInfo): ?>
            <p>Company: <?php echo htmlspecialchars($clientInfo['company_name']); ?></p>
            <p>Role: <?php echo $clientInfo['client_role'] === 'primary' ? 'Primary Contact' : 'Team Member'; ?></p>
        <?php endif; ?>
        
        <div style="margin-top: 20px;">
            <a href="logout.php" class="btn" style="display: inline-block; width: auto; padding: 10px 20px; text-decoration: none;">Logout</a>
        </div>
        
        <!-- Dashboard content will be added in next phases -->
    </div>
</body>
</html>