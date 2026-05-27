<?php include __DIR__ . '/../header.php'; ?>

<form method="post" style="display: flex; flex-direction: column; gap: 10px;">
    <input type="text" name="name" value="<?= htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8') ?>">
    <textarea name="text"><?= htmlspecialchars($article->getText(), ENT_QUOTES, 'UTF-8') ?></textarea>
    <button type="submit">Сохранить</button>
</form>
<p>Автор: <?= $article->getAuthor()->getNickname() ?></p>

<?php include __DIR__ . '/../footer.php'; ?>