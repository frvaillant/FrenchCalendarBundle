<?php

use Symfony\Component\Dotenv\Dotenv;

// On cherche le vendor/ le plus proche
$autoloadPaths = [
    __DIR__ . '/../../../vendor/autoload.php',   // si le bundle est dans vendor/
];

$autoloadFound = false;

foreach ($autoloadPaths as $path) {
    if (file_exists($path)) {
        require $path;
        $autoloadFound = true;
        break;
    }
}

if (!$autoloadFound) {
    throw new RuntimeException('Unable to find the Composer autoloader.');
}

// Charge les variables d’environnement si présentes
$dotenvPath = dirname(__DIR__, 2) . '/.env';
if (file_exists($dotenvPath) && class_exists(Dotenv::class) && method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv($dotenvPath);
}

if ($_SERVER['APP_DEBUG'] ?? false) {
    umask(0000);
}

