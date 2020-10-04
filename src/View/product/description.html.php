<?php

/** @var \Model\Entity\Product[] $productList */
$body = function () use ($productList, $path) {
    ?>
    <p>Описание наших курсов</p>
<?php
            $position = 0;
    foreach ($productList as $key => $product) {
        echo $position % 3 ? '' : '<br>'; ?>
                <p>
                    <p style="color: palevioletred"><?= $product->getName() ?></p>
                    <?= $product->getDescription() ?>
                </p>
<?php
    }
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Описание курсов',
        'body' => $body,
    ]
);