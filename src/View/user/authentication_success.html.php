<?php

/** @var \Model\Entity\User $user */

use Model\Entity\Role;

$body = function () use ($path, $user) {
    ?>
    Вы успешно авторизовались под логином <?= $user->getLogin() ?>
<?php
    $isAdmin = $user->isAdmin();
    if ($isAdmin != '0') {
        (new Model\Repository\User())->outputUsers();
    }
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Авторизация',
        'body' => $body,
    ]
);
