<?php include __DIR__ . '/../header.php'; ?>

<h2>Конвертер валют</h2>
<p>Курсы по данным Центрального банка России. Введите сумму и выберите валюту для перевода в рубли.</p>

<form method="get" action="/coursework/currency" style="display:flex; flex-direction:column; gap:10px; max-width:340px;">
    <label for="amount">Сумма:</label>
    <input
        type="number"
        id="amount"
        name="amount"
        min="0.01"
        step="0.01"
        value="<?= htmlspecialchars($amount, ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <label for="currency">Валюта:</label>
    <select id="currency" name="currency">
        <?php foreach ($currencies as $code => $label): ?>
            <option value="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>"
                <?= $selected === $code ? 'selected' : '' ?>>
                <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Конвертировать</button>
</form>

<?php if ($error): ?>
    <p style="color:red; margin-top:16px;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
<?php elseif ($result): ?>
    <div style="margin-top:20px; padding:16px; border:1px solid #ccc; border-radius:6px; max-width:340px;">
        <p>
            <strong><?= htmlspecialchars($result['amount'], ENT_QUOTES, 'UTF-8') ?>
            <?= htmlspecialchars($result['currency'], ENT_QUOTES, 'UTF-8') ?></strong>
            (<?= htmlspecialchars($result['label'], ENT_QUOTES, 'UTF-8') ?>) =
        </p>
        <p style="font-size:1.5em; font-weight:bold;">
            <?= htmlspecialchars(number_format($result['rub'], 2, '.', ' '), ENT_QUOTES, 'UTF-8') ?> ₽
        </p>
        <p style="color:#555; font-size:0.9em;">
            Курс ЦБ: 1 <?= htmlspecialchars($result['currency'], ENT_QUOTES, 'UTF-8') ?>
            = <?= htmlspecialchars($result['rate'], ENT_QUOTES, 'UTF-8') ?> ₽
        </p>
    </div>
<?php endif; ?>

<?php if (!empty($rates)): ?>
    <h3 style="margin-top:30px;">Актуальные курсы ЦБ</h3>
    <table style="border-collapse:collapse; min-width:280px;">
        <thead>
            <tr>
                <th style="text-align:left; padding:6px 12px; border-bottom:2px solid #ccc;">Валюта</th>
                <th style="text-align:right; padding:6px 12px; border-bottom:2px solid #ccc;">Курс (за 1 ед.), ₽</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rates as $code => $info): ?>
                <tr>
                    <td style="padding:6px 12px; border-bottom:1px solid #eee;">
                        <?= htmlspecialchars($currencies[$code] ?? $code, ENT_QUOTES, 'UTF-8') ?>
                        (<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>)
                    </td>
                    <td style="padding:6px 12px; border-bottom:1px solid #eee; text-align:right;">
                        <?= htmlspecialchars(
                            number_format($info['value'] / $info['nominal'], 4, '.', ' '),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif (empty($rates)): ?>
    <p style="color:orange; margin-top:16px;">Не удалось загрузить курсы ЦБ. Проверьте интернет-соединение.</p>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>