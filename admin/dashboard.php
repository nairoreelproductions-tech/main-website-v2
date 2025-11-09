<?php
/**
 * Admin Dashboard
 */

require_once '../config/database.php';
require_once '../includes/functions.php';

// Check if user is logged in and is admin
requireAdmin();

// Get admin name
$adminEmail = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Nairoreel Portal</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard">
        <h1>Welcome to Admin Dashboard</h1>
        <p>Logged in as: <?php echo htmlspecialchars($adminEmail); ?></p>
        
        <div style="margin-top: 20px;">
            <a href="logout.php" class="btn" style="display: inline-block; width: auto; padding: 10px 20px; text-decoration: none;">Logout</a>
        </div>
        
        <!-- Dashboard content will be added in next phases -->
    </div>
</body>
</html>