<?php
require_once 'config/database.php';

echo "<h2>Password Hash Test</h2>";

// Test the admin password
$testEmail = 'brandon@nairoreelproductions.com';
$testPassword = 'admin123';

$stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
$stmt->execute([$testEmail]);
$user = $stmt->fetch();

if ($user) {
    echo "✅ User found: " . $user['email'] . "<br>";
    echo "Stored hash: " . substr($user['password'], 0, 30) . "...<br><br>";
    
    echo "Testing password: '$testPassword'<br>";
    
    if (password_verify($testPassword, $user['password'])) {
        echo "✅ Password matches!<br>";
    } else {
        echo "❌ Password does NOT match<br><br>";
        
        echo "<strong>Let's create a new hash for '$testPassword':</strong><br>";
        $newHash = password_hash($testPassword, PASSWORD_DEFAULT);
        echo "New hash: $newHash<br><br>";
        
        echo "<strong>SQL to update password:</strong><br>";
        echo "<code>UPDATE users SET password = '$newHash' WHERE email = '$testEmail';</code>";
    }
} else {
    echo "❌ User not found";
}
?>