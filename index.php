<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/App/Core/Settings/routes.php';  // Загружаем маршруты

use Core\Application;

echo $_SESSION['user']['email'];

$app = new Application();
$app->run();
