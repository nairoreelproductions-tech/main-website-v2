<?php
/*require_once 'config/database.php';

// IMPORTANT: Delete this file after creating your users for security!

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    // Generate hash using YOUR server's PHP version
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$email, $hashedPassword, $role]);
        
        echo "✅ User created successfully!<br>";
        echo "Email: $email<br>";
        echo "Role: $role<br>";
        echo "Hash: $hashedPassword<br>";
    } catch (PDOException $e) {
        echo "❌ Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
    <style>
        body { font-family: Arial; padding: 40px; background: #000; color: #fff; }
        form { max-width: 400px; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; background: #2a2a2a; border: 1px solid #444; color: #fff; }
        button { padding: 12px 24px; background: #EA1821; color: #fff; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Create New User</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
            <option value="client">Client</option>
        </select>
        <button type="submit">Create User</button>
    </form>
</body>
</html>