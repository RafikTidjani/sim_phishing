<?php
// Configuration centrale de la démo (DB + redirection)
// Pilote au choix: 'mysql' (par défaut) ou 'sqlite'.

return [
    // Pilote sélectionné (surchargé par l'env PHISH_DRIVER si présent)
    'driver' => getenv('PHISH_DRIVER') ?: 'mysql',

    // SQLite
    'sqlite' => [
        // Fichier DB dans le dossier courant
        'path' => __DIR__ . DIRECTORY_SEPARATOR . 'submissions.sqlite',
    ],

    // MySQL / MariaDB
    'mysql' => [
        'host' => getenv('PHISH_DB_HOST') ?: '127.0.0.1',
        'port' => getenv('PHISH_DB_PORT') ?: '3306',
        'dbname' => getenv('PHISH_DB_NAME') ?: 'phish_demo',
        'user' => getenv('PHISH_DB_USER') ?: 'root',
        'pass' => getenv('PHISH_DB_PASS') ?: '',
        'charset' => 'utf8mb4',
    ],

    // URL de redirection après succès (modifiable via PHISH_REDIRECT_URL)
    'redirect_url' => getenv('PHISH_REDIRECT_URL') ?: 'https://facebook.com',
];
