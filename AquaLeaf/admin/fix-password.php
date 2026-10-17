<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

echo "<h1>Fix Admin Password</h1>";
echo "<style>body{font-family:Arial,sans-serif;max-width:600px;margin:50px auto;padding:20px}.success{color:green}.error{color:red}.info{color:#06c}</style>";

try {
    $email = 'admin@aqualeaf.com';
    $new_password = 'admin123';

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $exists = $stmt->fetch();

    $hash = password_hash($new_password, PASSWORD_DEFAULT);

    if ($exists) {
        $stmt = $pdo->prepare("UPDATE users SET password = ?, role = 'super_admin', status = 'active' WHERE email = ?");
        $stmt->execute([$hash, $email]);
        echo "<p class='success'>✓ Admin password updated.</p>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (name,email,password,role,status) VALUES (?,?,?,?,?)");
        $stmt->execute(['Super Admin', $email, $hash, 'super_admin', 'active']);
        echo "<p class='success'>✓ Admin user created.</p>";
    }

    echo "<h2>Login Credentials</h2>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
    echo "<p><strong>Password:</strong> " . htmlspecialchars($new_password) . "</p>";
    echo "<p><a href='" . SITE_URL . "/admin/login.php'>Open Admin Login</a></p>";
    echo "<p class='info'>IMPORTANT: Delete this file from the server after use.</p>";
} catch (PDOException $e) {
    echo "<p class='error'>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
