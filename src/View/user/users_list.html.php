<?php

/** @var \Model\Entity\User $user */

use Model\Entity\Role;

$body = function () use ($path, $user) {
    ?>
<?php
    $users = (new Model\Repository\User())->outputUsers();
    echo 'Все зарегистрированные пользователи:';
    echo '<table border="1">';
    echo '<tr><th align="right">Имя</th><th align="right">Дата рождения</th><th align="right">Логин</th><th align="right">Роль</th></tr>';
    foreach ($users as $item) {
        echo '<tr><td align="right">';
        echo (string)$item['name'];
        echo '</td><td align="right">';
        echo (string)$item['birthDate'];
        echo '</td><td align="right">';
        echo (string)$item['login'];
        echo '</td><td align="right">';
        echo (string)$item['role']['role'];
        echo '</td></tr>';
    }
    echo '</table>';
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Cписок пользователей',
        'body' => $body,
    ]
);
