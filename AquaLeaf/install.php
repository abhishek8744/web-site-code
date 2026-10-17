<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

echo "<h1>AquaLeaf - Database Installation</h1>";
echo "<style>body{font-family:Arial,sans-serif;max-width:800px;margin:50px auto;padding:20px}.success{color:green}.error{color:red}.info{color:#06c}li{margin:8px 0}</style>";

try {
    echo "<p class='success'>✓ Connected to the configured MySQL database.</p>";

    $schemaFile = __DIR__ . '/database/schema.sql';
    if (!is_file($schemaFile)) {
        throw new RuntimeException('database/schema.sql was not found.');
    }

    $schema = file_get_contents($schemaFile);
    if ($schema === false) {
        throw new RuntimeException('Could not read database/schema.sql.');
    }

    // Hostinger databases are normally created in hPanel/phpMyAdmin first.
    // This installer only creates/updates tables and does NOT drop the database.
    $pdo->exec($schema);
    echo "<p class='success'>✓ Database schema imported.</p>";

    $tables = ['users','products','orders','order_items','coupons','support_tickets',
        'faqs','settings','product_screenshots','coupon_usage','ticket_messages',
        'password_resets','cart'];

    foreach ($tables as $table) {
        $stmt = $pdo->prepare("SHOW TABLES LIKE ?");
        $stmt->execute([$table]);
        echo $stmt->fetch() ? "<p class='success'>✓ $table</p>" : "<p class='error'>✗ $table missing</p>";
    }

    echo "<h2 class='success'>Installation Complete</h2>";
    echo "<p>Website: <a href='" . SITE_URL . "'>" . SITE_URL . "</a></p>";
    echo "<p>Admin: <a href='" . SITE_URL . "/admin/login.php'>" . SITE_URL . "/admin/login.php</a></p>";
    echo "<p><strong>Default admin:</strong> admin@aqualeaf.com / admin123</p>";
    echo "<p class='info'><strong>Security:</strong> Delete install.php, reset-admin.php and admin/fix-password.php after setup.</p>";
} catch (Throwable $e) {
    echo "<p class='error'><strong>Installation error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Check config/database.php and make sure the Hostinger database already exists.</p>";
}
?>
