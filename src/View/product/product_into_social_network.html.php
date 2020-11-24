<?php

use Service\SocialNetwork\ISocialNetwork;

/** @var \Service\SocialNetwork\ISocialNetwork $network */
/** @var string $course */
$body = function () use ($network, $course) {
    echo  'Сообщение с курсом '.$course.' в '.$network.' отправлено';
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Отправка сообщения в соц. сети',
        'body' => $body,
    ]
);
