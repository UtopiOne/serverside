<?php
function get_menu()
{
    $action = $_GET['action'] ?? 'view';
    $links = [
        'view'   => 'Просмотр',
        'add'    => 'Добавление записи',
        'edit'   => 'Редактирование записи',
        'delete' => 'Удаление записи',
    ];
    $html = '';
    foreach ($links as $key => $label) {
        $class = $action === $key ? ' class="active"' : '';
        $html .= "<a href=\"index.php?action={$key}\"{$class}>{$label}</a>\n";
    }
    return $html;
}
