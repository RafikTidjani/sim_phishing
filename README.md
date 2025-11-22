Simulation de phishing (pédagogique, local) — README

IMPORTANT — Éthique et périmètre
- Ce dossier contient une démonstration pédagogique destinée à un LAB local.
- Ne pas usurper un site réel, un logo ou un nom de marque.
- Ne jamais demander ni saisir de vrais identifiants. Utiliser des comptes/tests fictifs.
- Exécuter uniquement avec consentement explicite des participants, dans un environnement isolé.

Objectif pédagogique
- Montrer le parcours type d’un faux formulaire de connexion: saisie → journalisation locale → redirection vers un site légitime de démonstration.
- Ici la redirection cible `https://example.org/` (site neutre). Ne changez pas vers un domaine réel simulant une marque.

Pré‑requis
- PHP 8+ en local (pas besoin d’un serveur web complet, le serveur embarqué suffit).
- OS: Windows/macOS/Linux.

Lancer en local
1) Ouvrir un terminal dans ce dossier `sim_phishing`.
2) Démarrer le serveur PHP embarqué:
   `php -S 127.0.0.1:8080 -t .`
3) Ouvrir: `http://127.0.0.1:8080/`

Fichier HOSTS (démo sans marque)
- Pour simuler une redirection locale mais sans utiliser une marque réelle, ajoutez une entrée vers un nom interne, par ex. `phish.lab`:
  - Windows: éditer en administrateur `C:\Windows\System32\drivers\etc\hosts`
  - Ajouter la ligne: `127.0.0.1    phish.lab`
  - Naviguer ensuite sur `http://phish.lab:8080/`

NB: N’utilisez pas de domaines de marques (ex: facebook.com). Le but est de comprendre le mécanisme, pas d’usurper.

Parcours de la démo
- `index.php` affiche un formulaire avec un avertissement clair.
- `receive.php` enregistre localement dans `submissions.sqlite` (SQLite) avec date/IP/UA.
- `success.php` affiche un message (pas de redirection automatique).
- `view.php?key=changeme` liste les entrées (clé rudimentaire à modifier pour la démo).

Structure des fichiers
- `index.php` — page d’accueil + formulaire
- `receive.php` — traitement de la soumission (+ création DB si besoin)
- `success.php` — page de confirmation + redirection sûre
- `view.php` — liste des soumissions (accès par clé)

Nettoyage des données de démo
- Pour purger, supprimez le fichier `submissions.sqlite` quand le serveur est arrêté.

Idées pour le compte rendu (CR)
- Description du mécanisme de résolution (HOSTS vs DNS) et des limites.
- Captures d’écran du flux local (formulaire, DB, redirection vers example.org).
- Risques et parades: DNSSEC/DoH/DoT, principe du moindre privilège (pas d’admin),
  supervision des modifications du fichier HOSTS, HSTS/TLS, EDR/AV, sensibilisation.
