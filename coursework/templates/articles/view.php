<?php
$title = htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8');
include __DIR__ . '/../header.php';
?>

<h1><?= htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8') ?></h1>
<p><?= nl2br(htmlspecialchars($article->getText(), ENT_QUOTES, 'UTF-8')) ?></p>
<p>Автор: <?= htmlspecialchars($article->getAuthor()->getNickname(), ENT_QUOTES, 'UTF-8') ?></p>

<div style="display:flex;gap:12px;margin-top:16px;">
    <a href="/coursework/article/<?= $article->getId() ?>/edit">Редактировать</a>
    <form method="post" action="/coursework/articles/<?= $article->getId() ?>/delete"
          onsubmit="return confirm('Удалить статью?')">
        <button type="submit" class="btn-danger">Удалить</button>
    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
