<?php
const PAGE_SIZE = 10;

enum SortOrder: string
{
    case ASC = 'ASC';
    case DESC = 'DESC';
}

enum SortTypes: string
{
    case TimeAdded = 'time_added';
    case Surname = 'surname';
    case Birthday = 'birthday';
}

function get_total(PDO $db): int
{
    return (int) $db->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
}

function get_items(PDO $db, int $page = 1, SortTypes $sortType = SortTypes::Surname, SortOrder $sortOrder = SortOrder::ASC): array
{
    $offset = ($page - 1) * PAGE_SIZE;
    $column = $sortType === SortTypes::TimeAdded ? 'id' : $sortType->value;
    $dir    = $sortOrder->value;
    $stmt = $db->prepare("SELECT * FROM contacts ORDER BY $column $dir LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', PAGE_SIZE, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function sort_link(string $label, SortTypes $col, SortTypes $current, SortOrder $order, int $page): string
{
    $isActive  = $col === $current;
    $nextOrder = ($isActive && $order === SortOrder::ASC) ? SortOrder::DESC : SortOrder::ASC;
    $arrow     = $isActive ? ($order === SortOrder::ASC ? ' ▲' : ' ▼') : '';
    $url = '?action=view&page=' . $page . '&sort=' . urlencode($col->value) . '&order=' . urlencode($nextOrder->value);
    return '<a href="' . $url . '">' . htmlspecialchars($label . $arrow) . '</a>';
}

function get_viewer(PDO $db, int $page = 1, SortTypes $sortType = SortTypes::Surname, SortOrder $sortOrder = SortOrder::ASC): string
{
    $sortType  = SortTypes::tryFrom($_GET['sort'] ?? '') ?? SortTypes::Surname;
    $sortOrder = SortOrder::tryFrom(strtoupper($_GET['order'] ?? '')) ?? SortOrder::ASC;
    $total = get_total($db);
    $page  = max(1, (int) ($_GET['page'] ?? 1));
    $pages = (int) ceil($total / PAGE_SIZE);
    $page  = min($page, max(1, $pages));
    $rows  = get_items($db, $page, $sortType, $sortOrder);

    $sortQ  = '&sort=' . urlencode($sortType->value) . '&order=' . urlencode($sortOrder->value);

    ob_start(); ?>
    <div class="sort-bar">
        <span>Сортировка:</span>
        <?= sort_link('Фамилия', SortTypes::Surname, $sortType, $sortOrder, $page) ?>
        <?= sort_link('Дата рождения', SortTypes::Birthday, $sortType, $sortOrder, $page) ?>
        <?= sort_link('По добавлению', SortTypes::TimeAdded, $sortType, $sortOrder, $page) ?>
    </div>
    <table>
        <tr>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Пол</th>
            <th>Дата рождения</th>
            <th>Телефон</th>
            <th>Место жительства</th>
            <th>Email</th>
            <th>Комментарий</th>
            <th>#</th>
        </tr>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['surname']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['patronymic']) ?></td>
                <td><?= htmlspecialchars($row['gender']) ?></td>
                <td><?= htmlspecialchars($row['birthday']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= htmlspecialchars($row['location']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['comment']) ?></td>
                <td><?= htmlspecialchars($row['id']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php if ($pages > 1): ?>
        <nav class="pagination">
            <?php if ($page > 1): ?>
                <a href="?action=view&page=<?= $page - 1 . $sortQ ?>">&laquo; Назад</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <?php if ($i === $page): ?>
                    <span class="current"><?= $i ?></span>
                <?php else: ?>
                    <a href="?action=view&page=<?= $i . $sortQ ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($page < $pages): ?>
                <a href="?action=view&page=<?= $page + 1 . $sortQ ?>">Вперёд &raquo;</a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
<?php
    return ob_get_clean();
}
