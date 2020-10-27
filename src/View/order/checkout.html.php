<?php

/** @var float $discount */
/** @var float $totalPrice */
$body = function () use ($discount, $totalPrice) {
    ?>
    <form method="post">
        <table cellpadding="10">
            <tr>
                <td colspan="3" align="center">Ваша скидка <?= (string)$discount ?> %</td>
            </tr>
            <tr>
                <td colspan="3" align="center">Покупка на сумму <?= (string)$totalPrice ?> руб. успешно совершена</td>
            </tr>
        </table>
    </form>
    <?php
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Покупка',
        'body' => $body,
    ]
);
