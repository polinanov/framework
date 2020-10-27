<?php

/** @var \Model\Entity\User $user */

use Model\Entity\Role;

$body = function () use ($path, $user) {
    ?>
<?php
    (new Model\Repository\User())->outputDataUser($user->getId());
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Личный кабинет',
        'body' => $body,
    ]
);
