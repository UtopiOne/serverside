<?php

function edit_item(PDO $db, int $id): bool
{
    try {
        $stmt = $db->prepare("UPDATE contacts SET surname = :surname, name = :name, patronymic = :patronymic, gender = :gender, birthday = :birthday, phone = :phone, location = :location, email = :email, comment = :comment WHERE id = :id");
        $stmt->execute([
            ':surname'    => trim($_POST['surname'] ?? ''),
            ':name'       => trim($_POST['name'] ?? ''),
            ':patronymic' => trim($_POST['patronymic'] ?? ''),
            ':gender'     => trim($_POST['gender'] ?? ''),
            ':birthday'   => trim($_POST['date'] ?? ''),
            ':phone'      => trim($_POST['phone'] ?? ''),
            ':location'   => trim($_POST['location'] ?? ''),
            ':email'      => trim($_POST['email'] ?? ''),
            ':comment'    => trim($_POST['comment'] ?? ''),
            ':id'         => $id
        ]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function get_item(PDO $db, int $id): ?array
{
    $stmt = $db->prepare("SELECT * FROM contacts WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function get_all_items(PDO $db): array
{
    return $db->query("SELECT id, surname, name FROM contacts ORDER BY surname ASC, name ASC")->fetchAll();
}

function get_edit_picker(array $items, int $selectedId): string
{
    ob_start(); ?>
    <ul class="edit-list">
        <?php foreach ($items as $item): ?>
            <a <?= (int) $item['id'] === $selectedId ? ' class="active"' : '' ?> href="?action=edit&id=<?= (int) $item['id'] ?>">
                <?= htmlspecialchars($item['surname'] . ' ' . $item['name']) ?>
            </a>
        <?php endforeach; ?>
    </ul>
<?php
    return ob_get_clean();
}

function get_edit_form(array $row, string $message = '', bool $success = false): string
{
    $id = (int) $row['id'];
    ob_start(); ?>
    <?php if ($message): ?>
        <p class="message <?= $success ? 'success' : 'error' ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form name="form_edit" method="post" action="index.php?action=edit&id=<?= $id ?>">
        <div class="column">
            <div class="add">
                <label>Фамилия</label>
                <input type="text" name="surname" placeholder="Фамилия" value="<?= htmlspecialchars($row['surname']) ?>">
            </div>
            <div class="add">
                <label>Имя</label>
                <input type="text" name="name" placeholder="Имя" value="<?= htmlspecialchars($row['name']) ?>">
            </div>
            <div class="add">
                <label>Отчество</label>
                <input type="text" name="patronymic" placeholder="Отчество" value="<?= htmlspecialchars($row['patronymic']) ?>">
            </div>
            <div class="add">
                <label>Пол</label>
                <select name="gender">
                    <option value=""></option>
                    <option value="мужской" <?= $row['gender'] === 'Мужской' ? 'selected' : '' ?>>мужской</option>
                    <option value="женский" <?= $row['gender'] === 'Женский' ? 'selected' : '' ?>>женский</option>
                </select>
            </div>
            <div class="add">
                <label>Дата рождения</label>
                <input type="date" name="date" value="<?= htmlspecialchars($row['birthday']) ?>">
            </div>
            <div class="add">
                <label>Телефон</label>
                <input type="text" name="phone" placeholder="Телефон" value="<?= htmlspecialchars($row['phone']) ?>">
            </div>
            <div class="add">
                <label>Адрес</label>
                <input type="text" name="location" placeholder="Адрес" value="<?= htmlspecialchars($row['location']) ?>">
            </div>
            <div class="add">
                <label>Email</label>
                <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($row['email']) ?>">
            </div>
            <div class="add">
                <label>Комментарий</label>
                <textarea name="comment" placeholder="Краткий комментарий"><?= htmlspecialchars($row['comment']) ?></textarea>
            </div>
            <button type="submit" name="button" class="form-btn">Сохранить</button>
            <a href="?action=edit" class="form-btn">← Назад к списку</a>
        </div>
    </form>
<?php
    return ob_get_clean();
}
