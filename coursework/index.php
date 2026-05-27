<?php

spl_autoload_register(static function (string $className): void {
    $prefix = 'MyProject\\';

    if (!str_starts_with($className, $prefix)) {
        return;
    }

    $relativePath = substr($className, strlen($prefix));
    $fileName = __DIR__ . '/src/MyProject/' . str_replace('\\', '/', $relativePath) . '.php';

    if (is_file($fileName)) {
        require_once $fileName;
    }
});

$routes = require __DIR__ . '/src/routes.php';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$basePath = str_replace('\\', '/', dirname($scriptName));


if ($basePath !== '/' && $basePath !== '.') {
    if (str_starts_with($path, $basePath)) {
        $path = substr($path, strlen($basePath)) ?: '/';
    }
}

$path = ltrim($path, '/');

if ($path === 'index.php') {
    $path = '';
}

foreach ($routes as $pattern => [$controllerClass, $actionName]) {
    if (preg_match($pattern, $path, $matches) !== 1) {
        continue;
    }

    array_shift($matches);
    $arguments = array_map(static function ($value) {
        if (is_string($value) && ctype_digit($value)) {
            return (int) $value;
        }

        return $value;
    }, $matches);

    $controller = new $controllerClass();
    $controller->$actionName(...$arguments);
    return;
}

$view = new \MyProject\View\View(__DIR__ . '/templates');
$view->renderHtml('errors/404.php', [], 404);
