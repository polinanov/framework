<?php

/** @var \Model\Entity\User $user */

use Model\Entity\Role;

$body = function () use ($path, $user) {
    ?>
<?php
    (new Model\Repository\User())->outputUsers();
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Cписок пользователей',
        'body' => $body,
    ]
);
