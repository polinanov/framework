<?php

/** @var \Model\Entity\User $user */
/** @var float $lastOrderAmount */

$body = function () use ($path, $user, $lastOrderAmount) {
    ?>
<?php
    $userRep = (new Model\Repository\User())->outputDataUser($user->getId());
        echo '<br>';
        echo 'Вы находитесь в личном кабинете пользователя';
        echo '<br><br>';
        echo 'Ваши данные:';
        echo '<table border="1">';
        echo '<tr><th align="right">Имя</th><th align="right">Дата рождения</th><th align="right">Сумма последнего заказа</th><th align="right">Логин</th></tr>';
        foreach ($userRep as $item) {
            if ($item['id'] == $user->getId()) {
                echo '<tr><td align="right">';
                echo (string)$item['name'];
                echo '</td><td align="right">';
                echo (string)$item['birthDate'];
                echo '</td><td align="right">';
                echo $lastOrderAmount;
                echo '</td><td align="right">';
                echo (string)$item['login'];
                echo '</td></tr>';
            }
        }
        echo '</table>';

};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Личный кабинет',
        'body' => $body,
    ]
);
