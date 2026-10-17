<?php
/**
 * AquaLeaf - Hostinger database configuration
 *
 * In Hostinger hPanel go to:
 * Websites -> Manage -> Databases -> MySQL Databases
 * and replace the four values below with the database details shown there.
 */
$host = 'localhost';
$dbname = 'u304593353_aqualeaf_db';
$username = 'u304593353_aqualeaf_admin';
$password = 'Poonam@874409';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    die(
        '<h2>AquaLeaf database connection failed</h2>' .
        '<p>Open <code>config/database.php</code> and enter your Hostinger MySQL database name, username and password.</p>'
    );
}
?>
