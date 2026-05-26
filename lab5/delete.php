<?php
function delete_item(PDO $db, int $id): bool
{
    $stmt = $db->prepare("DELETE FROM contacts WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

function get_delete_picker(array $items, int $selectedId = 0): string
{
    ob_start(); ?>
    <ul class="delete-list">
        <?php foreach ($items as $item): ?>
            <li>
                <a <?= (int) $item['id'] === $selectedId ? ' class="active"' : '' ?> href="?action=delete&id=<?= (int) $item['id'] ?>">
                    <?= htmlspecialchars($item['surname'] . ' ' . $item['name']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php
    return ob_get_clean();
}
