<?php
function add_item(PDO $db, array $row): bool
{
    $surname = trim($row['surname'] ?? '');
    $name = trim($row['name'] ?? '');
    $patronymic = trim($row['patronymic'] ?? '');
    $gender = trim($row['gender'] ?? '');
    $birthday = trim($row['date'] ?? '');
    $phone = trim($row['phone'] ?? '');
    $location = trim($row['location'] ?? '');
    $email = trim($row['email'] ?? '');
    $comment = trim($row['comment'] ?? '');

    $stmt = $db->prepare("
    INSERT INTO contacts (surname, name, patronymic, gender, birthday, phone, location, email, comment) 
    VALUES (:surname, :name, :patronymic, :gender, :birthday, :phone, :location, :email, :comment)
    ");
    try {
        $stmt->execute([
            ':surname' => $surname,
            ':name' => $name,
            ':patronymic' => $patronymic,
            ':gender' => $gender,
            ':birthday' => $birthday,
            ':phone' => $phone,
            ':location' => $location,
            ':email' => $email,
            ':comment' => $comment
        ]);
    } catch (PDOException $e) {
        return false;
    }
    return true;
}

function get_form(array $row = [], string $message = '', bool $success = false): string
{
    $row += [
        'surname'    => '',
        'name'       => '',
        'patronymic' => '',
        'gender'     => '',
        'date'       => '',
        'phone'      => '',
        'location'   => '',
        'email'      => '',
        'comment'    => ''
    ];

    ob_start(); ?>
    <?php if ($message): ?>
        <p class="message <?= $success ? 'success' : 'error' ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form name="form_add" method="post" action="index.php?action=add">
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
                    <option value="мужской" <?= $row['gender'] === 'мужской' ? 'selected' : '' ?>>мужской</option>
                    <option value="женский" <?= $row['gender'] === 'женский' ? 'selected' : '' ?>>женский</option>
                </select>
            </div>
            <div class="add">
                <label>Дата рождения</label>
                <input type="date" name="date" value="<?= htmlspecialchars($row['date']) ?>">
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
            <button type="submit" name="button" class="form-btn">Добавить</button>
        </div>
    </form>
<?php return ob_get_clean();
}
