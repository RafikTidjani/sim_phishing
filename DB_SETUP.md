Base de données — configuration rapide

SQLite (par défaut)
- Aucun prérequis côté serveur. Le fichier `submissions.sqlite` est créé à la volée.
- Assurez‑vous que l’extension `pdo_sqlite` est activée dans PHP.

MySQL/MariaDB
1) Créez une base de données, par exemple `phish_demo`.
2) Exécutez le script SQL suivant (même contenu que `schema_mysql.sql`):

```
CREATE TABLE IF NOT EXISTS submissions (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  ip VARCHAR(45) NOT NULL,
  user_agent TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

3) Paramétrez l’application pour utiliser MySQL via variables d’environnement:
- Sous PowerShell (session courante):

```
$env:PHISH_DRIVER='mysql'
$env:PHISH_DB_HOST='127.0.0.1'
$env:PHISH_DB_PORT='3306'
$env:PHISH_DB_NAME='phish_demo'
$env:PHISH_DB_USER='root'
$env:PHISH_DB_PASS=''
```

4) Redémarrez le serveur PHP: `php -S 127.0.0.1:8080 -t sim_phishing`

Dépannage
- Erreur « could not find driver »: activer `pdo_mysql` (pour MySQL) ou `pdo_sqlite` (pour SQLite) dans `php.ini`.
- Aucune ligne affichée dans `view.php`: vérifiez l’URL `view.php?key=changeme`, le driver sélectionné et les identifiants DB.

