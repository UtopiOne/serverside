<?php

/** @var string|null $title */
$resolvedTitle = $title ?? 'Мой блог';
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($resolvedTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/lab9/style.css">
</head>

<body>
    <div class="page">
        <header class="header">
            <h1 class="site-title"><a href="/lab9">Мой блог</a></h1>
        </header>

        <div class="layout">
            <main class="content">