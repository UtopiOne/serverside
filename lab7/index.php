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

if (preg_match('#^hello/([^/]+)$#', $path, $matches)) {
    $controller->sayHello($matches[1]);
    return;
}

if (preg_match('#^bye/([^/]+)$#', $path, $matches)) {
    $controller->sayBye($matches[1]);
    return;
}

if ($path === 'about-me') {
    $controller->aboutMe();
    return;
}

if ($path === '/' || $path === '' || $path === 'index.php') {
    $controller->main();
    return;
}

http_response_code(404);
$controller->render('message', [
    'title' => 'Страница не найдена',
    'message' => 'Запрашиваемая страница не найдена.'
]);