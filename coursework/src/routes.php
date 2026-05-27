<?php

return [
    '~^articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~^article/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~^currency$~' => [\MyProject\Controllers\CurrencyController::class, 'view'],
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main'],
];
