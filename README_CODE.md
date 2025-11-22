Code walkthrough (demo)
======================

But: démonstration pédagogique locale d’un faux formulaire de connexion. N’utilisez que des identifiants fictifs.

Fichiers principaux
- index.php : page d’accueil, mise en page à deux colonnes, formulaire POST vers receive.php.
- assets/style.css : styles (grille, cartes, boutons).
- receive.php : traite le POST, valide les champs, choisit le driver DB, crée la table si besoin, insère email/password/IP/User-Agent, puis redirige vers success.php.
- success.php : affiche une confirmation et redirige (meta refresh 2s) vers l’URL définie dans config.php (`redirect_url` ou env `PHISH_REDIRECT_URL`).
- view.php : liste les soumissions, protégée par une clé de requête (`VIEW_KEY`). Lit via PDO sur le même driver.
- config.php : sélection du driver (`mysql` par défaut, ou `sqlite`) et paramètres DB. Contient aussi `redirect_url`.
- schema_mysql.sql : schéma MySQL équivalent à la création auto dans receive.php.
- submissions.sqlite : fichier SQLite créé si vous utilisez le driver sqlite.

Flux de données
1) index.php affiche le formulaire (email, mot de passe).
2) receive.php :
   - vérifie que les champs ne sont pas vides,
   - ouvre la base (MySQL ou SQLite),
   - crée la table `submissions` si elle n’existe pas,
   - insère : email, password, ip, user_agent, created_at,
   - redirige vers success.php.
3) success.php remercie et redirige après 2 s vers l’URL cible.
4) view.php?key=changeme lit et affiche les enregistrements.

Changement de driver DB
- Par défaut : MySQL (env `PHISH_DRIVER=mysql` implicite). Paramètres dans config.php ou via env `PHISH_DB_HOST/PORT/NAME/USER/PASS`.
- Pour SQLite : `PHISH_DRIVER=sqlite` (utilise submissions.sqlite dans le dossier).

Sécurité (cadre démo)
- Ne pas saisir de vrais identifiants.
- Ne pas exposer cette démo sur Internet.
- Changez VIEW_KEY si vous gardez view.php.

Commande de lancement (port 8080)
```
php -S 127.0.0.1:8080 -t sim_phishing
```

Tester
- Formulaire : http://127.0.0.1:8080/
- Vue DB : http://127.0.0.1:8080/view.php?key=changeme

