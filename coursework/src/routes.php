<?php

return [
    '~^articles/add$~'          => [\MyProject\Controllers\ArticlesController::class, 'add'],
    '~^articles/(\d+)$~'        => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~^article/(\d+)/edit$~'    => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~^articles/(\d+)/delete$~' => [\MyProject\Controllers\ArticlesController::class, 'delete'],
    '~^currency$~'              => [\MyProject\Controllers\CurrencyController::class, 'view'],
    '~^$~'                      => [\MyProject\Controllers\MainController::class, 'main'],
];
