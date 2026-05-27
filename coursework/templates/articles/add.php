<?php
$title = 'Новая статья';
include __DIR__ . '/../header.php';
?>

<h2>Новая статья</h2>
<form method="post" style="display: flex; flex-direction: column; gap: 10px;">
    <input type="text" name="name" placeholder="Заголовок" required>
    <textarea name="text" placeholder="Текст статьи" required></textarea>
    <button type="submit">Опубликовать</button>
</form>

<?php include __DIR__ . '/../footer.php'; ?>
