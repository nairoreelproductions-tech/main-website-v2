<?php
require_once 'config/database.php';

echo "<h2>Database Connection Test</h2>";

// Test 1: Check if connection exists
if (isset($conn)) {
    echo "✅ Connection object exists<br>";
} else {
    echo "❌ Connection object does NOT exist<br>";
    die();
}

// Test 2: Try a simple query
try {
    $stmt = $conn->query("SELECT COUNT(*) as count FROM users");
    $result = $stmt->fetch();
    echo "✅ Database connected successfully!<br>";
    echo "✅ Found " . $result['count'] . " users in database<br><br>";
    
    // Test 3: Show all users
    echo "<h3>Users in database:</h3>";
    $stmt = $conn->query("SELECT id, email, role FROM users");
    while ($user = $stmt->fetch()) {
        echo "ID: {$user['id']}, Email: {$user['email']}, Role: {$user['role']}<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}
?>