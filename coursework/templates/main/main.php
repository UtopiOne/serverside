<?php
$title = 'Список статей';
include __DIR__ . '/../header.php';
?>

<?php foreach ($articles as $article): ?>
    <article class="article-preview">
        <h2>
            <a href="/coursework/articles/<?= $article->getId() ?>">
                <?= htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8') ?>
            </a>
            <a href="/coursework/articles/<?= $article->getId() ?>/edit" class="edit-link">[редактировать]</a>
        </h2>
        <p><?= nl2br(htmlspecialchars($article->getText(), ENT_QUOTES, 'UTF-8')) ?></p>
        <hr>
    </article>
<?php endforeach; ?>

<?php include __DIR__ . '/../footer.php'; ?>