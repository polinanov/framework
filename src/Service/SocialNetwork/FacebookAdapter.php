<?php

declare(strict_types = 1);

namespace Service\SocialNetwork;

class FacebookAdapter implements ISocialNetwork
{
    private Facebook $adapt;
    public function __construct(Facebook $facebook)
    {
        $this->adapt = $facebook;
    }

    public function send(string $message): void
    {
        // реализация метода send
    }
}
