<?php
require_once "add.php";
require_once "menu.php";
require_once "viewer.php";
require_once "edit.php";
require_once "delete.php";

$db = init_db();

$message = '';
$success = false;

$deleteMessage = '';
$deleteSuccess = false;
$deletedItemSurname = '';

if (($_GET['action'] ?? '') === 'delete' && ($deleteId = (int) ($_GET['id'] ?? 0)) > 0) {
    $deletedItemSurname = get_item($db, $deleteId)['surname'] ?? '';
    if (delete_item($db, $deleteId)) {
        $deleteSuccess = true;
        $deleteMessage = 'Запись с фамилией ' . htmlspecialchars($deletedItemSurname) . ' удалена.';
        $deleteId = 0;
    } else {
        $deleteMessage = 'Ошибка при удалении.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['action'] ?? '') === 'edit') {
    $editId = (int) ($_GET['id'] ?? 0);
    $editRow = $editId ? get_item($db, $editId) : null;
    if ($editRow) {
        $editRow = array_merge($editRow, [
            'surname'    => trim($_POST['surname'] ?? ''),
            'name'       => trim($_POST['name'] ?? ''),
            'patronymic' => trim($_POST['patronymic'] ?? ''),
            'gender'     => trim($_POST['gender'] ?? ''),
            'birthday'   => trim($_POST['date'] ?? ''),
            'phone'      => trim($_POST['phone'] ?? ''),
            'location'   => trim($_POST['location'] ?? ''),
            'email'      => trim($_POST['email'] ?? ''),
            'comment'    => trim($_POST['comment'] ?? ''),
        ]);
        if (edit_item($db, $editId)) {
            $editSuccess = true;
            $editMessage = 'Запись успешно обновлена!';
        } else {
            $editSuccess = false;
            $editMessage = 'Ошибка при обновлении записи.';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['action'] ?? '') === 'add') {
    $row = [
        'surname'    => trim($_POST['surname'] ?? ''),
        'name'       => trim($_POST['name'] ?? ''),
        'patronymic' => trim($_POST['patronymic'] ?? ''),
        'gender'     => trim($_POST['gender'] ?? ''),
        'date'       => trim($_POST['date'] ?? ''),
        'phone'      => trim($_POST['phone'] ?? ''),
        'location'   => trim($_POST['location'] ?? ''),
        'email'      => trim($_POST['email'] ?? ''),
        'comment'    => trim($_POST['comment'] ?? ''),
    ];
    if (add_item($db, $row)) {
        $success = true;
        $message = 'Запись успешно добавлена!';
    } else {
        $message = 'Ошибка при добавлении записи.';
    }
}

$row ??= [
    'surname'    => '',
    'name'       => '',
    'patronymic' => '',
    'gender'     => '',
    'date'       => '',
    'phone'      => '',
    'location'   => '',
    'email'      => '',
    'comment'    => '',
];

function init_db(): PDO
{
    static $db = null;
    if ($db === null) {
        $db = new PDO('sqlite:database/database.sqlite');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $db->exec("CREATE TABLE IF NOT EXISTS contacts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            surname TEXT NOT NULL,
            name TEXT NOT NULL,
            patronymic TEXT NOT NULL,
            gender TEXT NOT NULL,
            birthday TEXT NOT NULL,
            phone TEXT NOT NULL,
            location TEXT NOT NULL,
            email TEXT NOT NULL,
            comment TEXT NOT NULL
        )");
    }

    // Fill up the DB with 20 items
    $stmt = $db->query("SELECT COUNT(*) FROM contacts");
    $count = $stmt->fetchColumn();
    if ($count < 20) {
        $db->beginTransaction();
        $stmt = $db->prepare("INSERT INTO contacts (surname, name, patronymic,  gender, birthday, phone, location, email, comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        for ($i = $count + 1; $i <= 20; $i++) {
            $stmt->execute([
                "Surname $i",
                "Name $i",
                "Patronymic $i",
                "Мужской",
                "1990-01-01",
                "1234567890",
                "Location $i",
                "email$i@example.com",
                "Comment $i"
            ]);
        }
        $db->commit();
    }

    return $db;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 5</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <?php echo get_menu(); ?>
    </header>

    <main>
        <?php if (($_GET['action'] ?? '') === 'add'): ?>
            <?php echo get_form($row, $message, $success); ?>
        <?php elseif (($_GET['action'] ?? 'view') === 'view'): ?>
            <?php echo get_viewer($db, (int) ($_GET['page'] ?? 1), SortTypes::TimeAdded, SortOrder::ASC); ?>
        <?php elseif (($_GET['action'] ?? '') === 'delete'): ?>
            <?php $allDeleteItems = get_all_items($db); ?>
            <?php if ($deleteMessage): ?>
                <p class="message <?= $deleteSuccess ? 'success' : 'error' ?>"><?= htmlspecialchars($deleteMessage) ?></p>
            <?php endif; ?>
            <div class="delete-layout">
                <?= get_delete_picker($allDeleteItems, $deleteId ?? 0) ?>

            </div>
        <?php elseif (($_GET['action'] ?? '') === 'edit'): ?>
            <?php
            $allEditItems = get_all_items($db);
            if (!isset($editId) || $editId === 0) {
                $editId = (int) ($_GET['id'] ?? 0);
            }
            if ($editId === 0 && $allEditItems) {
                $editId = (int) $allEditItems[0]['id'];
            }
            $editRow ??= ($editId ? get_item($db, $editId) : null);
            ?>
            <div class="edit-layout">
                <?= get_edit_picker($allEditItems, $editId) ?>
                <?php if ($editRow): ?>
                    <?= get_edit_form($editRow, $editMessage ?? '', $editSuccess ?? false) ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>