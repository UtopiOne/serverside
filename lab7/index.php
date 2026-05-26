<?php

spl_autoload_register(function (string $className) {
    $prefix = 'lab7\\';
    if (str_starts_with($className, $prefix)) {
        $relative = substr($className, strlen($prefix));
        require_once __DIR__ . '/' . str_replace('\\', '/', $relative) . '.php';
    }
});

$controller = new \lab7\Controllers\MainController();

$path = trim($_SERVER['PATH_INFO'] ?? '', '/');
$parts = explode('/', $path);

if ($parts[0] === 'bye' && !empty($parts[1])) {
    $controller->sayBye($parts[1]);
} elseif (!empty($_GET['name'])) {
    $controller->sayHello($_GET['name']);
} else {
    $controller->main();
}