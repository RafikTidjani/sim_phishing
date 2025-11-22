<?php
// Confirmation page: informs the user and redirects to the configured site.
// Educational use only — never forward real credentials.

$config = require __DIR__ . '/config.php';
$redirectUrl = $config['redirect_url'] ?? 'https://monsitedelecole.com';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Soumission enregistrée — Démo</title>
  <meta http-equiv="refresh" content="2;url=<?= htmlspecialchars($redirectUrl, ENT_QUOTES) ?>" />
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; background:#f2f3f5; margin:0; }
    .wrap { max-width: 560px; margin: 5rem auto; background: #fff; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 25px rgba(0,0,0,.08); }
    h1 { margin-top: 0; font-size: 1.4rem; }
  </style>
  <meta http-equiv="Content-Security-Policy" content="default-src 'self'; style-src 'self' 'unsafe-inline';" />
</head>
<body>
</body>
</html>
